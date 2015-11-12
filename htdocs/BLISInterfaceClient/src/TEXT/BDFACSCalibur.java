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
package TEXT;




import configuration.configuration;
import configuration.xmlparser;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.attribute.FileTime;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import log.DisplayMessageType;
import java.nio.file.attribute.BasicFileAttributes;
import java.util.Scanner;


/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class BDFACSCalibur extends Thread {
    
     private static List<String> testIDs = new ArrayList<String>();
     static final char Start_Block = (char)2;
     static final char End_Block = (char)3;
     static final char CARRIAGE_RETURN = 13; 
     private static StringBuilder datarecieved = new StringBuilder();
     private boolean stopped = false;
     private static FileTime  ReadTime;
     private static long ReadLine = 1;   
     BufferedReader in=null;   
    
    
     private static String getFileName()
     {
         return new utilities().getFileName( settings.FILE_NAME_FORMAT,settings.FILE_EXTENSION);
     }
      private static String getSubDIRName()
     {
         return new utilities().getFileName( settings.SUB_DIRECTORY_FORMAT,null);
     }
     
  @Override
    public void run() {
        log.AddToDisplay.Display("BD FACSCalibur handler started...", DisplayMessageType.TITLE);
        log.AddToDisplay.Display("Checking file availability  on this system...", DisplayMessageType.INFORMATION);
        if(openFile())
        {
            log.AddToDisplay.Display("File Available and accessible...", DisplayMessageType.INFORMATION);
            setTestIDs();
             if(system.settings.ENABLE_AUTO_POOL)
         {
            while(!stopped)
            {             
                try {
                    //getBLISTests("",false);
                    manageResults();
                    Thread.sleep(system.settings.POOL_INTERVAL * 1000);
                } catch (InterruptedException ex) {
                    Logger.getLogger(BDFACSCalibur.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
            log.AddToDisplay.Display("ABX Pentra 60 C+ Handler Stopped",log.DisplayMessageType.TITLE);
         }
         else
         {
             log.AddToDisplay.Display("Auto Pull Disabled. Only manual activity can be performed",log.DisplayMessageType.INFORMATION);
         }
        }
        else
        {
            log.AddToDisplay.Display("Could not open file", DisplayMessageType.ERROR);
        }
        
        
      }
    
    private boolean openFile()
    {
        boolean flag = false;
        
         String path = settings.BASE_DIRECTORY 
                 + System.getProperty("file.separator")
                 + getSubDIRName()
                 + System.getProperty("file.separator")
                 + getFileName();    
         
         File config_file = new File(path);
        Scanner scanner = null;
        try {
            scanner = new Scanner(config_file);
           flag = true;
        } catch (FileNotFoundException ex) {
            flag = false;
            Logger.getLogger(configuration.class.getName()).log(Level.SEVERE, null, ex);
            log.logger.PrintStackTrace(ex);
        }
        
        return  flag;
    }
    
    public static void HandleDataInput(String data)
    {
        String[] DataParts = data.split(String.valueOf(settings.SEPERATOR_CHAR));
        if( DataParts.length > 1)
        {
            //String Type  = DataParts[1].trim();
            int mID=0;
            float value = 0;
            boolean flag = false;
            //17 is where the actual test values starts
            //7=> SampleID, 8=>Case Number
            String specimen_id = DataParts[8];
            if(!specimen_id.equals("."))
            {
                    for(int i=17;i<DataParts.length;i++)
                    {
                        mID = getMeasureID(Integer.toString(i+1));
                        if(mID > 0)
                        {
                            try
                            {
                                value = Float.parseFloat(DataParts[i].trim());
                            }catch(NumberFormatException e){
                                try{
                                value = 0;
                                }catch(NumberFormatException ex){}
                            
                            }
                            if(SaveResults(specimen_id, mID,value))
                            {
                                flag = true;
                            }
                        }

                    }
            }
                    if(flag)
                    {
                         log.AddToDisplay.Display("Results with Code: "+specimen_id +" sent to BLIS sucessfully",DisplayMessageType.INFORMATION);
                    }
                    else
                    {
                         log.AddToDisplay.Display("Test with Code: "+specimen_id +" not Found on BLIS",DisplayMessageType.WARNING);
                    }
                           
        }        
           
    }
    
    private void manageResults() 
    {
        if(shouldRead())
        {
             String path = settings.BASE_DIRECTORY 
                 + System.getProperty("file.separator")
                 + getSubDIRName()
                 + System.getProperty("file.separator")
                 + getFileName();         

            File in_file = new File(path);
            String line="";
            try {
                in=new BufferedReader(new InputStreamReader(new FileInputStream(in_file)));
                 long dCount =0;
                while((line = in.readLine()) != null)
                {
                    if(dCount < ReadLine)
                    {
                        dCount++;
                        continue;
                    }         
                    if(stopped)
                        break;
                    
                    ReadLine++;
                    dCount++;
                    if(!line.isEmpty())
                    {
                         HandleDataInput(line);
                    }
                    
                }
            } catch (FileNotFoundException ex) {
                Logger.getLogger(BDFACSCalibur.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
                Logger.getLogger(BDFACSCalibur.class.getName()).log(Level.SEVERE, null, ex);
            }    
             
           //ReadTime =FileTime.fromMillis(DateT system.utilities.getSystemDate(""));
            //TODO
            
        }
       
    }
    
    private boolean shouldRead()
    {
        boolean flag = false;
         String path = settings.BASE_DIRECTORY 
                 + System.getProperty("file.separator")
                 + getSubDIRName()
                 + System.getProperty("file.separator")
                 + getFileName();         

        Path file = Paths.get(path);
         try {           
             BasicFileAttributes attr = Files.readAttributes(file, BasicFileAttributes.class);
             if(null == ReadTime || (attr.lastModifiedTime().compareTo(ReadTime) > 0))
             {
                 flag = true;
                 
             }            
             else
             {
                 flag = false;
             }
                 
             
         } catch (IOException ex) {
             Logger.getLogger(BDFACSCalibur.class.getName()).log(Level.SEVERE, null, ex);
         }
        
        return flag;
    }   
   
    
    public void Stop()
    {
    
         log.AddToDisplay.Display("Stoping handler", log.DisplayMessageType.TITLE);
         
         stopped = true;           
         this.interrupt();
        /*if(Manager.closeOpenedPort())
        {
            log.AddToDisplay.Display("Port Closed sucessfully", log.DisplayMessageType.INFORMATION);
        }*/
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
        xmlparser p = new xmlparser("configs/BDFACSCalibur/bdfacscalibur.xml");
        try {
            data = p.getMicros60Filter(whichdata);           
        } catch (Exception ex) {
            Logger.getLogger(BDFACSCalibur.class.getName()).log(Level.SEVERE, null, ex);
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
