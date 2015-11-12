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
public class BT3000PlusChameleon extends Thread {
    
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
     
     private static String End_Block = "L|1|N";
     
     private static StringBuilder datarecieved = new StringBuilder();
    
      private static MSGMODE appState = MSGMODE.IDLE;
      private static Queue<String> PatientTest = new LinkedList<>();
      public  static int TimeOut = 30;
      public  static int RetryCOunt  = 10;
      public static String order ="";
     // static ManageTimeOut tmObj = null;
      
  @Override
    public void run() {
        log.AddToDisplay.Display("BT 3000Plus Chameleon handler started...", DisplayMessageType.TITLE);
        log.AddToDisplay.Display("Checking available ports on this system...", DisplayMessageType.INFORMATION);
        String[] ports = Manager.getSerialPorts();
        log.AddToDisplay.Display("Avaliable ports:", DisplayMessageType.TITLE);
       for(int i = 0; i < ports.length; i++){           
           log.AddToDisplay.Display(ports[i],log.DisplayMessageType.INFORMATION);
        }            
       log.AddToDisplay.Display("Now connecting to port "+RS232Settings.COMPORT , DisplayMessageType.TITLE);
       if(Manager.openPortforData("BT3000PlusChameleon"))
       {
           log.AddToDisplay.Display("Connected sucessfully",DisplayMessageType.INFORMATION);   
           setTestIDs();
       }      
      
    }
    
    public static void HandleDataInput(String data)
    {       
        datarecieved.append(data);
        if(datarecieved.toString().contains(End_Block+CR+ETX))
        {
             int endindex = datarecieved.toString().indexOf(String.valueOf(End_Block+CR+ETX));
             if(endindex > 0)
             {
                processMessage(datarecieved.toString().substring(0,endindex));
             }
             String temp = datarecieved.substring(endindex);
             datarecieved = new StringBuilder();
             if(temp.length()> 0)
             {                
                 if(!temp.startsWith(End_Block))
                    HandleDataInput(temp);                
             }     
             
        }        
        
           /* if(data.contains(String.valueOf(End_Block)))
            {
                int endindex = data.indexOf(String.valueOf(End_Block));
                datarecieved.append(data.substring(0, endindex));
                processMessage();
                datarecieved = new StringBuilder();
                if(data.substring(endindex).length()> 1)
                {
                    if(data.startsWith(String.valueOf(End_Block)))
                        HandleDataInput(data.substring(endindex+2));
                    else                        
                        HandleDataInput(data.substring(endindex));
                }
            }
            else
            {
                datarecieved.append(data);
            }*/
           
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
                       
                       log.AddToDisplay.Display("Sending test with Code: "+SampleList.get(i).aux_id + " to BT 3000Plus Chameleon",DisplayMessageType.INFORMATION);
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
    private static void processMessage( String Data)
    {
        try
        {
             String[] msgParts = Data.split("\r"+ETX);
                String pidParts[] = msgParts[1].split("\\|");
                if(pidParts.length > 5)
                {
                    String patientid = pidParts[3].trim();
                    String SampleID = msgParts[2].split("\\|")[2].trim();
                    //SampleID = utilities.getSystemDate("YYYY") + SampleID;
                    //SampleID =  patientid;
                    int mID=0;
                    float value = 0;
                    boolean flag = false;
                    for(int i=3;i<msgParts.length-1;i++)
                    {
                        if(msgParts[i].split("\\|")[0].endsWith("R"))
                        {
                            mID = getMeasureID(msgParts[i].split("\\|")[2].split("\\^")[3].trim());
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
                else
                {
                    log.AddToDisplay.Display("QC or BACKGROUND CHECK information Skipped",DisplayMessageType.INFORMATION);
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
        xmlparser p = new xmlparser("configs/BT3000Plus/bt3000pluschameleon.xml");
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

