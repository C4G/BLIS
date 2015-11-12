/* 
 *  C4G BLIS Equipment Interface Client
 * 
 *  Project funded by PEPFAR
 * 
 *  Philip Boakye      - Team Lead  
 *  Patricia Enninful  - Technical Officer
 *  Stephen Adjei-Kyei - Software Developer
 * 
 */
package RS232;


import BLIS.sampledata;
import static RS232.ABXPentra80.RetryCOunt;
import static RS232.ABXPentra80.order;
import TCPIP.BT3000PlusChameleon;
import configuration.xmlparser;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Date;
import java.util.LinkedList;
import java.util.List;
import java.util.Queue;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import log.DisplayMessageType;
import system.SampleDataJSON;
import system.utilities;


/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class ABXPentra80 extends Thread {
    
     public enum  MSGMODE
    {
        WAIT_FOR_ACK(0),
        ACK_RECEIVED(1),
        IDLE(2),
        WORKING(3),
        PATIENT_SENT(4),      
        PATIENT_SENT_ACK(5),
        PATIENT_SENT_ERR(6),
        RESULTS_REQUESTED(7),
        RESULTS_RECEIVING(8),
        RESULTS_RECEIVED(9),
        NO_RESULTS(10),
        ACK_SENT(11),
        DATA_RECEIVING(12);
        
        private MSGMODE(int value)
        {
            this.Value = value;
        }
        
        private int Value;
        
    }
     
     private static List<String> testIDs = new ArrayList<String>();
  
     private static final char STX = 0x02;  
     private static final char ETX = 0x03;
     public static final char EOT = 0x04;
     private static final char ENQ = 0x05;
     private static final char ACK = 0x06;
     private static final char NAK = 0x15;
     private static final char NUL = 0x00;
     private static final char CR = 0x0D;
     private static final char LF = 0x0A;
     
     private static StringBuilder datarecieved = new StringBuilder();
    
      private static MSGMODE appState = MSGMODE.IDLE;
      private static Queue<String> PatientTest = new LinkedList<>();
      public  static int TimeOut = 30;
      public  static int RetryCOunt  = 10;
      public static String order ="";
     // static ManageTimeOut tmObj = null;
      
  @Override
    public void run() {
        log.AddToDisplay.Display("ABX Pentra 80 handler started...", DisplayMessageType.TITLE);
        log.AddToDisplay.Display("Checking available ports on this system...", DisplayMessageType.INFORMATION);
        String[] ports = Manager.getSerialPorts();
        log.AddToDisplay.Display("Avaliable ports:", DisplayMessageType.TITLE);
       for(int i = 0; i < ports.length; i++){           
           log.AddToDisplay.Display(ports[i],log.DisplayMessageType.INFORMATION);
        }            
       log.AddToDisplay.Display("Now connecting to port "+RS232Settings.COMPORT , DisplayMessageType.TITLE);
       if(Manager.openPortforData("ABX Pentra 80"))
       {
           log.AddToDisplay.Display("Connected sucessfully",DisplayMessageType.INFORMATION);   
           setTestIDs();
       }      
      
    }
    
    public static void HandleDataInput(String data)
    {
        if(appState == MSGMODE.WORKING)
        {
            Manager.writeToSerialPort(NAK);            
        }
        else
        {
            if(data.charAt(0) == NUL)
            {
              log.AddToDisplay.Display("Received <NUL>",DisplayMessageType.INFORMATION);
              Manager.writeToSerialPort(NUL);            
              
            }
            if(data.charAt(0) == ENQ)
            {
              log.AddToDisplay.Display("Received <ENQ>",DisplayMessageType.INFORMATION);
              datarecieved = new StringBuilder();
              appState = MSGMODE.ACK_SENT;
              Manager.writeToSerialPort(ACK);             
            }            
            if(appState == MSGMODE.ACK_SENT)
            {
                datarecieved.append(data);
                if(data.endsWith(String.valueOf(LF)))
                {
                     Manager.writeToSerialPort(ACK);                     
                }
                else if(data.endsWith(String.valueOf(EOT)))
                {
                    appState = MSGMODE.WORKING;
                    processMessage();
                    appState = MSGMODE.IDLE;
                }                
            }
            if(appState == MSGMODE.WAIT_FOR_ACK)
            {
                if(data.charAt(0) == ACK)
                {                   
                    //tmObj.Stop();
                   log.AddToDisplay.Display("Received <ACK>",DisplayMessageType.INFORMATION);                   
                   if(PatientTest.size()>0)
                    {
                         order = PatientTest.poll();
                         Manager.writeToSerialPort(order); 
                         /*if(!PatientTest.isEmpty())
                         {                            
                            tmObj = new ManageTimeOut();
                            tmObj.start(); 
                         }*/
                         
                         if(PatientTest.isEmpty())
                         {
                            log.AddToDisplay.Display("Sent <EOT>",DisplayMessageType.INFORMATION);  
                            log.AddToDisplay.Display("Sent successfully",DisplayMessageType.TITLE);   
                         }
                    }                  
                   
                  
                }
                else
                {
                  log.AddToDisplay.Display("Received <"+ data + ">",DisplayMessageType.INFORMATION);
                }
            }
            else
            {
                  log.AddToDisplay.Display("Received <"+ data + ">",DisplayMessageType.INFORMATION);
            }
        }
           
    }
    public void getFromBlis(String barcode)
     {   
         
       getBLISTests(barcode,true);
        
     }
    
    private static void getBLISTests(String aux_id, boolean flag)
     {
         try
         {
            String data = BLIS.blis.getSampleData(aux_id,"","",getSpecimenFilter(2), getSpecimenFilter(4));
            List<sampledata> SampleList = SampleDataJSON.getSampleObject(data);
            SampleList = SampleDataJSON.normaliseResults(SampleList);
            if(SampleList.size() > 0)
            {            
                for (int i=0;i<SampleList.size();i++) 
                {  
                       
                       log.AddToDisplay.Display("Sending test with Code: "+SampleList.get(i).aux_id + " to ABX Pentra 80",DisplayMessageType.INFORMATION);
                       prepare(SampleList.get(i));
                       appState = MSGMODE.WAIT_FOR_ACK;
                       order = String.valueOf(ENQ);
                      Manager.writeToSerialPort(ENQ);  
                      //tmObj = new ManageTimeOut();
                      //tmObj.start();                        
                      
                      
                       
                }

            }
             else
              {
                 // AddtoQueue(null, query);
                 if(flag)                         
                   log.AddToDisplay.Display("Sample with barcode: "+aux_id +" does not exist in BLIS",DisplayMessageType.WARNING);
             }
         }catch(Exception ex)
         {
             log.AddToDisplay.Display("Error: "+ex.getMessage(),DisplayMessageType.ERROR);
             log.logger.PrintStackTrace(ex);
         }
     }
    
    private static void prepare(sampledata get)
   {
      
       PatientTest.clear();
       StringBuffer strData = new StringBuffer();
       strData.append(STX); 
       StringBuffer strTemp = new StringBuffer();
       strTemp.append("1H|\\^&|||LIS|||||||P|E1394-97|"); 
       strTemp.append(utilities.getSystemDate("yyyyMMddHHmmss"));
       strTemp.append(CR);
       strTemp.append(ETX);       
       strData.append(strTemp.toString());
       strData.append(utilities.getCheckSum(strTemp.toString()));
       strData.append(CR);
       strData.append(LF);       
       PatientTest.add(strData.toString());
       strData = new StringBuffer();
       strTemp = new StringBuffer();       
       strData.append(STX);      
       strTemp.append("2P|1||");
       strTemp.append(get.surr_id);
       strTemp.append("||");
       strTemp.append(get.name.trim().replaceFirst(" ", "^"));
       strTemp.append("||");
       String[] parts = utilities.getNormalizedDate(get.dob,get.partial_dob).split("-");
       strTemp.append(parts[0]).append(parts[1]).append(parts[2]);
       strTemp.append("|");
       strTemp.append(get.sex);
       strTemp.append("|||||||||||||||||");          
       strTemp.append("OPD");
       strTemp.append(CR);
       strTemp.append(ETX);       
       strData.append(strTemp.toString());
       strData.append(utilities.getCheckSum(strTemp.toString()));
       strData.append(CR);
       strData.append(LF); 
       PatientTest.add(strData.toString());
       strData = new StringBuffer();
       strTemp = new StringBuffer();      
       strData.append(STX);       //4O|1|SID007||^^^CBC|R||||||A<CR><ETX>04<CR><LF>;
       strTemp.append("3O|1|");      
       strTemp.append(get.aux_id);
       strTemp.append("||");
       strTemp.append("^^^DIF");
       strTemp.append("|R||||||A");            
       strTemp.append(CR);
       strTemp.append(ETX);
       strData.append(strTemp.toString());
       strData.append(utilities.getCheckSum(strTemp.toString()));
       strData.append(CR);
       strData.append(LF); 
       PatientTest.add(strData.toString());
       strData = new StringBuffer();
       strTemp = new StringBuffer();       
       strData.append(STX);   
       strTemp.append("4L|1|N");    
       strTemp.append(CR);
       strTemp.append(ETX);
       strData.append(strTemp.toString());
       strData.append(utilities.getCheckSum(strTemp.toString()));
       strData.append(CR);
       strData.append(LF); 
       PatientTest.add(strData.toString());
       strData = new StringBuffer();
       strData.append(EOT);
       PatientTest.add(strData.toString());
            
   }
    private static void processMessage()
    {
        try
        {
            String[] PatientParts = datarecieved.toString().split(String.valueOf(STX)+"[\\d]P");
            for(int p=1;p<PatientParts.length;p++)
            {
            
                String[] msgParts = PatientParts[p].split(String.valueOf(LF));
                String SampleParts[] = msgParts[1].split("\\|");
                
               // String patientid = pidParts[3].trim();
                String SampleID = SampleParts[2].trim();
                if(SampleParts.length > 2)
                {
                    //SampleID = utilities.getSystemDate("YYYY") + SampleID;
                    //SampleID =  patientid;
                    int mID=0;
                    float value = 0;
                    boolean flag = false;
                    for(int i=2;i<msgParts.length-1;i++)
                    {
                        if(msgParts[i].split("\\|")[0].endsWith("R"))
                        {
                            mID = getMeasureID(msgParts[i].split("\\|")[1].trim());
                            if(mID > 0)
                            {
                                try
                                {
                                    value = Float.parseFloat(msgParts[i].split("\\|")[3]);
                                }catch(NumberFormatException e){
                                    try{
                                    value = 0;
                                    }catch(NumberFormatException ex){}

                                }
                                if(SaveResults(SampleID, mID,value))
                                {
                                    flag = true;
                                }
                            }
                        }
                    }
                     if(flag)
                        {
                             log.AddToDisplay.Display("\nResults with Code: "+SampleID +" sent to BLIS sucessfully",DisplayMessageType.INFORMATION);
                        }
                        else
                        {
                             log.AddToDisplay.Display("\nTest with Code: "+SampleID +" not Found on BLIS",DisplayMessageType.WARNING);
                        }


                }
            }
        }catch(Exception ex)
        {
            log.AddToDisplay.Display("Error:"+ex.getMessage(),DisplayMessageType.ERROR);
        }
    }
    
    public void Stop()
    {
        if(Manager.closeOpenedPort())
        {
            log.AddToDisplay.Display("Port Closed sucessfully", log.DisplayMessageType.INFORMATION);
        }
    }
    
    
    private void setTestIDs()
     {
         String equipmentid = getSpecimenFilter(3);
         String blismeasureid = getSpecimenFilter(4);
        
         String[] equipmentids = equipmentid.split(",");
         String[] blismeasureids = blismeasureid.split(",");
         for(int i=0;i<equipmentids.length;i++)
         {
             testIDs.add(equipmentids[i]+";"+blismeasureids[i]);             
         }
        
     }
    
    private static String getSpecimenFilter(int whichdata)
    {
        String data = "";
        xmlparser p = new xmlparser("configs/pentra80/abxpentra80.xml");
        try {
            data = p.getMicros60Filter(whichdata);           
        } catch (Exception ex) {
            Logger.getLogger(ABXPentra80.class.getName()).log(Level.SEVERE, null, ex);
        }        
        return data;        
    }
    
     private static int getMeasureID(String equipmentID)
     {
         int measureid = 0;
         for(int i=0;i<testIDs.size();i++)
         {
             if(testIDs.get(i).split(";")[0].equalsIgnoreCase(equipmentID))
             {
                 measureid = Integer.parseInt(testIDs.get(i).split(";")[1]);
                 break;
             }
         }
         
         return measureid;
     }
     private static String getEquipmentID(String measureID)
     {
         String equipmentID = "";
         for(int i=0;i<testIDs.size();i++)
         {
             if(testIDs.get(i).split(";")[1].equalsIgnoreCase(measureID))
             {
                 equipmentID = testIDs.get(i).split(";")[0];
                 break;
             }
         }
         
         return equipmentID;
     }
    private static boolean SaveResults(String barcode,int MeasureID, float value)
     {
         
         
          boolean flag = false;       
          if("1".equals(BLIS.blis.saveResults(barcode,MeasureID,value,0)))
           {
              flag = true;
            }
                          
         return flag;
         
     }      
    
   
}

class ManageTimeOut extends Thread
    {       
           
         long TimeOutTime = 0;        
         boolean stop = false;
         private int retries =0;
         @Override
         public void run() {
            
             TimeOutTime = (System.currentTimeMillis() +  ABXPentra80.TimeOut * 1000);
             while(!stop)
             {
                 if(!order.isEmpty())
                 {
                     if(order.charAt(0)== ABXPentra80.EOT)
                         break;
                 }
                 else
                 {
                     break;
                 }
                if(TimeOutReached())
                {
                    if((retries <= RetryCOunt))
                    {
                        log.AddToDisplay.Display("Retry:"+(retries+1), log.DisplayMessageType.INFORMATION);   
                        if(order.length() == 1)                            
                            Manager.writeToSerialPort( order.charAt(0));
                        else
                            Manager.writeToSerialPort( order);
                         TimeOutTime = (System.currentTimeMillis() +  ABXPentra80.TimeOut * 1000);
                         retries++;
                    }
                    else
                    {
                        log.AddToDisplay.Display("Will not retry again:", log.DisplayMessageType.WARNING);
                        stop = true;
                    }
                }
             }
         }
         
         
         public void Stop()
         {             
             stop = true;
         }                 
         
         
         private boolean TimeOutReached()
         {
             boolean flag = false;
             if(System.currentTimeMillis() > TimeOutTime)
                 flag = true;            
             
             return flag;
         }
    }
