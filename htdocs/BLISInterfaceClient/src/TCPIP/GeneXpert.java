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
package TCPIP;

import BLIS.sampledata;
import configuration.xmlparser;
import java.io.*;
import java.net.*;
import java.util.Iterator;
import java.util.LinkedList;
import java.util.Queue;
import log.DisplayMessageType;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;
import system.SampleDataJSON;
import system.settings;
import system.utilities;
import ui.MainForm;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class GeneXpert extends Thread{
        
    String read;
    boolean first =true;   
    static DataOutputStream outToEquipment=null;
    ServerSocket welcomeSocket=null;
    Socket connSock = null;
    Iterator list= null;
    static Queue<String> OutQueue=new LinkedList<>();
    private static List<String> testIDs = new ArrayList<>();
    private static Queue<String> PatientTest = new LinkedList<>();
    private static String ASTMMsgs ="";
     
    boolean stopped = false;
    //Queue<String> InQueue=new LinkedList<>();
    private static final char CARRIAGE_RETURN = 13; 
    private static final char STX = 0x02;
    private static final char ACK = 0x06;
    private static final char EOT = 0x04;
    private static final char NAK = 0x15;
    private static final char NUL = 0x00;
    private static final char ENQ = 0x05;
    private static final char ETX = 0x03;
    private static final char CR = 0x0D;
    private static final char LF = 0x0A;
    private static final char ETB = 0x17;
   
    private static MODE appMode = MODE.IDLE;
    public enum  MSGTYPE
    {
        QUERY(0),
        RESULTS(1),
        ACK_RECEIVED(2),
        ACK(3),
        ENQ(4),
        NAK(5),
        EOT(6),
        STX(7),
        ETX(8),
        UNKNOWN(-1);
       
        
        private MSGTYPE(int value)
        {
            this.Value = value;
        }
        
        private int Value;
        
    }
    
   enum MODE
   {
       SENDING_QUERY,
       RECEIVEING_RESULTS,
       IDLE;
   }
    public void Stop()
    {
        try {
            
            stopped = true;
            if(null != connSock)
                connSock.close();
            if(null !=welcomeSocket)
                 welcomeSocket.close();
//            connSock.close();
             log.AddToDisplay.Display("GeneXpert handler stopped", DisplayMessageType.TITLE);
        } catch (IOException ex) {
            log.logger.Logger(ex.getMessage());
        }
        
    }
      @Override
    public void run() {             
         
        try
        {
            log.AddToDisplay.Display("GeneXpert handler started...", DisplayMessageType.TITLE); 
            if(tcpsettings.SERVER_MODE)
            {                
                log.AddToDisplay.Display("Starting Server socket on port "+tcpsettings.PORT, DisplayMessageType.INFORMATION);
                welcomeSocket = new ServerSocket(tcpsettings.PORT);
  		log.AddToDisplay.Display("Waiting for Equipment connection...", DisplayMessageType.INFORMATION);
  		log.AddToDisplay.Display("Listening on port "+ tcpsettings.PORT+"...",DisplayMessageType.INFORMATION);
                connSock = welcomeSocket.accept();    
            }
            else
            {
                log.AddToDisplay.Display("Starting Client socket on IP "+tcpsettings.EQUIPMENT_IP +" on port  "+tcpsettings.PORT, DisplayMessageType.INFORMATION);
               connSock = new Socket(tcpsettings.EQUIPMENT_IP, tcpsettings.PORT);
            }
                log.AddToDisplay.Display("GeneXpert is now Connected...",DisplayMessageType.INFORMATION);
                first=false;
                if(!tcpsettings.SERVER_MODE)
                {
                    connSock.setKeepAlive(true);
                }
                ClientThread client = new ClientThread(connSock,"GENEXPERT");
                client.start();
                String message ;
                outToEquipment= new DataOutputStream(connSock.getOutputStream());
                 setTestIDs();
                while(!stopped)
                {                 
                    synchronized(OutQueue)
                    {                        
                        while(!OutQueue.isEmpty())
                        {
                           // System.out.println("Message found in sending queue");
                           // log.AddToDisplay.Display("Message found in sending queue",DisplayMessageType.TITLE);
                            //log.logger.Logger("Message found in sending queue");
                            message =(String) OutQueue.poll();                             
                            outToEquipment.writeBytes(message);
                            //System.out.println(message+ "sent sucessfully");
                            log.AddToDisplay.Display("[ "+message+ " ] sent successfully",DisplayMessageType.INFORMATION);
                            //log.logger.Logger(message+ "sent sucessfully");
                        }
                    }
                    
                
                }


         }
         catch(IOException e)
         {
                if(first)
		{
                    if(tcpsettings.SERVER_MODE)
                        log.AddToDisplay.Display("could not listen on port :"+tcpsettings.PORT + " "+e.getMessage(),DisplayMessageType.ERROR);
                    else
                        log.AddToDisplay.Display("could not connect to server: "+tcpsettings.EQUIPMENT_IP+" on port :"+tcpsettings.PORT + " "+e.getMessage(),DisplayMessageType.ERROR);
                   // log.logger.Logger(e.getMessage());
		}
		else
		{
                    log.AddToDisplay.Display("GeneXpert client is now disconnected!",DisplayMessageType.WARNING);
                    log.logger.Logger(e.getMessage());
		}


	}
       
    }
    
    public void getFromBlis(String barcode)
     {   
         
       getBLISTests(barcode,true);
        
     }
    
    private static void resetCon()
    {
        /* if(!tcpsettings.SERVER_MODE)
               {
                 stopped = true;
                 if(null != connSock)
                 try {
                     connSock.close();
                 } catch (IOException ex) {
                     Logger.getLogger(BT3000PlusChameleon.class.getName()).log(Level.SEVERE, null, ex);
                 }
                   MainForm.btobj = new BT3000PlusChameleon();
                   MainForm.btobj.start();
               }*/
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
                    appMode = MODE.SENDING_QUERY;                    
                       log.AddToDisplay.Display("Sending test with Code: "+SampleList.get(i).aux_id + " to GeneXpert",DisplayMessageType.INFORMATION);
                       prepare(SampleList.get(i)); 
                       AddtoQueue(ENQ);
                       /*while(appMode != MODE.IDLE)
                       {
                           Thread.sleep(100);
                       }*/
                       
                }

            }
             else
              {
                 // AddtoQueue(null, query);
                  appMode = MODE.SENDING_QUERY;
                  AddtoQueue(ENQ);
                  noDataResponse();
                 if(flag)   
                 {
                   log.AddToDisplay.Display("Sample with code: "+aux_id +" does not exist in BLIS",DisplayMessageType.ERROR);
                 }
             }
         }catch(Exception ex)
         {
             log.logger.PrintStackTrace(ex);
         }
     }
   
   private static boolean sendNow(String message)
   {
       boolean status = false;
        try {
            outToEquipment.writeBytes(message);
        } catch (IOException ex) {
            Logger.getLogger(GeneXpert.class.getName()).log(Level.SEVERE, null, ex);
        }
       log.AddToDisplay.Display("[ "+message+ " ] sent successfully",DisplayMessageType.INFORMATION);
       
       return status;
   }
   private static void AddtoQueue(char value) 
   {
       synchronized(OutQueue)
        {
            if(!OutQueue.isEmpty())
            {
                if(OutQueue.peek().charAt(0) != value)
                OutQueue.add(String.valueOf(value));
            }
            else
            {
                OutQueue.add(String.valueOf(value));
            }
            //log.logger.Logger("New message added to sending queue\n"+value);                                                          
       }
       
   }
   private static void noDataResponse()
   {
       Random rand = new Random();

       PatientTest.clear();
       StringBuffer strData = new StringBuffer();
       strData.append(STX); 
       StringBuffer strTemp = new StringBuffer();
       strTemp.append("1H|@^\\|");
       strTemp.append(rand.nextInt(999999));
       strTemp.append("||BLIS|||||GeneXpert PC^GeneXpert^4.3||P|1394-97|");       
       strTemp.append(utilities.getSystemDate("yyyyMMddHHmmss"));
       strTemp.append(CR);   
       strTemp.append("L");
       strTemp.append("|");
       strTemp.append(1);
       strTemp.append("|I");
       strTemp.append(CR);            
       strTemp.append(ETX);  
       strData.append(strTemp.toString());
       strData.append(utilities.getCheckSum(strTemp.toString()));
       strData.append(CR);
       strData.append(LF); 
       PatientTest.add(strData.toString());  
   }
   private static void prepare(sampledata get)
   {
       Random rand = new Random();

       PatientTest.clear();
       StringBuffer strData = new StringBuffer();
       strData.append(STX); 
       StringBuffer strTemp = new StringBuffer();
       strTemp.append("1H|@^\\|");
       strTemp.append(rand.nextInt(999999));
       strTemp.append("||BLIS|||||GeneXpert PC^GeneXpert^4.3||P|1394-97|");       
       strTemp.append(utilities.getSystemDate("yyyyMMddHHmmss"));
       strTemp.append(CR);   
       strTemp.append("P|1|||");
       strTemp.append(get.surr_id);
       strTemp.append(CR);        
       String[] testparts = get.test_type_id.split(",");   
       int j=3;
       for(int i=0;i<testparts.length;i++,j++)
       {           
           if(j > 7)
               j=0;           
            strTemp.append("O");
            strTemp.append("|");
            strTemp.append(i+1);
            strTemp.append("|");
            strTemp.append(get.aux_id);
            strTemp.append("||^^^");
            strTemp.append(testparts[i]);
            strTemp.append("|R|");
            strTemp.append(utilities.getSystemDate("yyyyMMddHHmmss"));
            strTemp.append("|||||A||||ORH||||||||||Q");
            strTemp.append(CR);          
                               
       }
            strTemp.append("L");
            strTemp.append("|");
            strTemp.append(1);
            strTemp.append("|N");
            strTemp.append(CR);            
            strTemp.append(ETX);  
            strData.append(strTemp.toString());
            strData.append(utilities.getCheckSum(strTemp.toString()));
            strData.append(CR);
            strData.append(LF); 
            PatientTest.add(strData.toString());  
       
   }
    
      private static void AddtoQueue(String data) 
      {        
            
              synchronized(OutQueue)
               {
                   OutQueue.add(data);
                   log.logger.Logger("New message added to sending queue\n"+data);                                                          
               }
      }
      
      private static void process()
      {        
          int[] resultslocs = {3,22};
           if(!ASTMMsgs.isEmpty())
               {
                   //String.valueOf(STX)+"[\\d]
                   ASTMMsgs = ASTMMsgs.replaceAll(String.valueOf(STX)+"[\\d]", "");
                   ASTMMsgs = ASTMMsgs.replaceAll(String.valueOf(ETB)+String.valueOf(CR), "");
                   
                   String[] PatientParts = ASTMMsgs.trim().split("L\\|1\\|N"+String.valueOf(CR));
                    for(int p=0;p<PatientParts.length;p++)
                    {
                        String[] msgParts = PatientParts[p].trim().split("\r");
                         int id=0;
                         if(msgParts.length == 3)
                             id =1;
                         else
                             id =2;
                        String pidParts[] = msgParts[id].split("\\|");
                        if(pidParts.length > 4)
                        {
                            if("Q".equals(pidParts[0].trim()))
                            {
                                 String patientid = pidParts[2].split("\\^")[0].trim();                                 
                                 String SampleID = pidParts[2].split("\\^")[1].trim();
                                 getBLISTests(SampleID,true);
                                  
                            }
                            else if("C".equals(pidParts[0].trim()))
                            {
                                log.AddToDisplay.Display("last request has been cancelled by GeneXpert",DisplayMessageType.INFORMATION);
                                 appMode = MODE.IDLE;
                                synchronized(MainForm.set)
                                {
                                    MainForm.set = MainForm.RESET.NOW;
                                }
                            }
                            else
                            {
                                pidParts = msgParts[2].split("\\|");
                                String patientid = pidParts[2].split("\\^")[0].trim();
                                String SampleID = pidParts[2].split("\\^")[0].trim(); 
                                //SampleID = utilities.getSystemDate("YYYY") + SampleID;
                                //SampleID =  patientid;
                                int mID=0;
                                String value = "";
                                boolean flag = false;
                                if(msgParts.length > resultslocs[resultslocs.length -1] )
                                {
                                    for(int i=0;i<resultslocs.length;i++)
                                    {
                                        if(msgParts[resultslocs[i]].split("\\|")[0].endsWith("R"))
                                        {
                                            mID = getMeasureID(msgParts[resultslocs[i]].split("\\|")[2].split("\\^")[3].trim());
                                            if(mID > 0)
                                            {
                                                try
                                                {
                                                value = msgParts[resultslocs[i]].split("\\|")[3].split("\\^")[0].trim();
                                                }catch(ArrayIndexOutOfBoundsException ex){ value = "";}
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
                                    log.AddToDisplay.Display("Sample with code "+SampleID +" has been deleted from GeneXpert",DisplayMessageType.INFORMATION);
                                }
                                 
                                appMode = MODE.IDLE;
                                synchronized(MainForm.set)
                                {
                                    MainForm.set = MainForm.RESET.NOW;
                                }
                            }


                        }
                        else
                        {
                            log.AddToDisplay.Display("Message format not known: Skipped",DisplayMessageType.INFORMATION);
                        }                        
                    }
               }
           
           ASTMMsgs="";
          
      }
    public static void handleMessage(String message)
    {         
         synchronized(MainForm.set)
          {
             MainForm.set = MainForm.RESET.WAIT;
          }
        try
        {
            //String[] msgParts = message.split("\r");
            MSGTYPE type =getMessageType(message);           
            if(type == MSGTYPE.ENQ)
            {                
                AddtoQueue(ACK);
               //ASTMMsgs="";
               appMode = MODE.RECEIVEING_RESULTS;
            }
            else if(type == MSGTYPE.STX)
            {
                AddtoQueue(ACK);
               ASTMMsgs = ASTMMsgs + "\r"+message;
               appMode = MODE.RECEIVEING_RESULTS;
               if(ASTMMsgs.endsWith(String.valueOf(EOT)))
               {
                   process();
               }
                
            }
            else if (type == MSGTYPE.EOT)
            {                
                //todo handle results 
               process();
                
            }
            else if (type == MSGTYPE.NAK)
            {
                 log.AddToDisplay.Display("NAK Response from Analyzer",DisplayMessageType.ERROR);
            }
            else if(type == MSGTYPE.ACK)
            {
                if(appMode == MODE.SENDING_QUERY)
                {
                    if(PatientTest.size()>0)
                    {
                        AddtoQueue(PatientTest.poll());
                        /*while(PatientTest.size() > 0)
                        {
                            AddtoQueue(PatientTest.poll());
                        }*/
                        //AddtoQueue(EOT);
                    }
                    else
                    {
                        AddtoQueue(EOT);
                        Thread.sleep(500);
                        appMode = MODE.IDLE;
                        synchronized(MainForm.set)
                        {
                            MainForm.set = MainForm.RESET.NOW;
                        }
                    }
                }
                
               
               
            }          
            
        }catch(Exception ex)
        {
            log.AddToDisplay.Display("Processing Error Occured!",DisplayMessageType.ERROR);
            log.AddToDisplay.Display("Data format of Details received from Analyzer UNKNOWN",DisplayMessageType.ERROR);
            log.logger.PrintStackTrace(ex);
        }
       
    }
    
    private static MSGTYPE getMessageType(String msg)
    {
        MSGTYPE type = null;
        switch (msg.charAt(0))
        {
            case ACK:
                type = MSGTYPE.ACK;                
                break;
            case ENQ:
                type = MSGTYPE.ENQ;
                break;
            case EOT:
                type =MSGTYPE.EOT;
                break;
            case NAK:
                type = MSGTYPE.NAK;
                break;
            case STX:
                type = MSGTYPE.STX;
                break;
            case ETX:
                type = MSGTYPE.ETX;
                break;
            default:
                String[] parts = msg.split("\r");
                if(parts.length > 1 )
                {
                    if(parts[1].startsWith("Q|"))
                    {
                        type= MSGTYPE.QUERY;
                    }
                    else if (parts[1].startsWith("P|"))
                    {
                        type = MSGTYPE.RESULTS;
                    }
                    else
                    {
                        type =MSGTYPE.UNKNOWN;
                    }
                }
        }
            
        return type;
        
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
        xmlparser p = new xmlparser("configs/geneXpert/genexpert.xml");
        try {
            data = p.getMicros60Filter(whichdata);           
        } catch (Exception ex) {           
            log.logger.PrintStackTrace(ex);
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
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
     
    private static boolean SaveResults(String barcode,int MeasureID, String value)
     {
         
         
          boolean flag = false;       
          if("1".equals(BLIS.blis.saveResults(barcode,MeasureID,value)))
           {
              flag = true;
            }
                          
         return flag;
         
     } 
    
    
    
   }
