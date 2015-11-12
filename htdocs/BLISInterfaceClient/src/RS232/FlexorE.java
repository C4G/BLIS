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


import configuration.xmlparser;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;
import javax.script.ScriptException;
import log.DisplayMessageType;


/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class FlexorE extends Thread {
    
     
     private static List<String> testIDs = new ArrayList<String>();
     private static List<String> calctestIDs = new ArrayList<String>();
     static final char Start_Block = (char)2;
     static final char End_Block = (char)3;
     static final char CARRIAGE_RETURN = 13; 
     private static StringBuilder datarecieved = new StringBuilder();
     private static int TestStart;
    
  @Override
    public void run() {
        log.AddToDisplay.Display("Flexor E handler started...", DisplayMessageType.TITLE);
        log.AddToDisplay.Display("Checking available ports on this system...", DisplayMessageType.INFORMATION);
        String[] ports = Manager.getSerialPorts();
        log.AddToDisplay.Display("Avaliable ports:", DisplayMessageType.TITLE);
       for(int i = 0; i < ports.length; i++){           
           log.AddToDisplay.Display(ports[i],log.DisplayMessageType.INFORMATION);
        }            
       log.AddToDisplay.Display("Now connecting to port "+RS232Settings.COMPORT , DisplayMessageType.TITLE);
       if(Manager.openPortforData("Flexor E"))
       {
           log.AddToDisplay.Display("Connected sucessfully",DisplayMessageType.INFORMATION);   
           setTestIDs();
           setCalcTestIDs();
           TestStart = Integer.parseInt(getSpecimenFilter(7));        
         //  FlexorE.HandleDataInput("{R;Flexor;B;Blank;;15;ALB ;0.007  ;                                     ;Abs        ;TPRO;0.000  ;                 a                   ;Abs        ;ALP ;0.006  ;                                     ;dAbs/m     ;ALT ;0.002  ;                 a                   ;dAbs/m     ;GGT ;0.002  ;                                     ;dAbs/m     ;TBIL;0.002  ;                                     ;Abs        ;UREA;-0.018 ;                                     ;dAbs       ;CREA;0.001  ;                                     ;dAbs       ;AST ;0.001  ;                                     ;dAbs/m     ;CHOL;0.000  ;                                     ;Abs        ;HDL ;0.002  ;                                     ;Abs        ;TRIG;0.003  ;                                     ;Abs        ;GLUC;0.000  ;                                     ;Abs        ;U/A ;0.000  ;                                     ;Abs        ;CAL ;0.020  ;                 a                   ;Abs        ;}");
       }      
       
      
    }
    
    public static void HandleDataInput(String data)
    {
       
            if(data.charAt(0) == Start_Block)
            {
                datarecieved = new StringBuilder();                
            }
            if(data.contains(String.valueOf(End_Block)))
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
            }
            //datarecieved.append(data);
            /*if(data.charAt(data.length()-1) == End_Block)
            {
                processMessage();
            }  */        
       
           
    }
    private static void processMessage()
    {
       
        if(null == datarecieved.toString() || datarecieved.toString().isEmpty())
            return;
        String[] DataParts = datarecieved.toString().split(";");
        if(DataParts.length > 5)
        {
            String Type  = DataParts[2].trim();
            int mID=0;
            float value = 0;
            boolean flag = false;
                           
                    String specimen_id = DataParts[3].trim();
                    for(int i=TestStart;i<DataParts.length;i+=4)
                    {
                        mID = getMeasureID(DataParts[i].trim());
                        if(mID > 0)
                        {
                            try
                            {
                                value = Float.parseFloat(DataParts[i+1].trim());
                            }catch(NumberFormatException e){
                                try{
                                value = 0;
                                }catch(NumberFormatException ex){}
                            
                            }
                            PrepareCalcTests(DataParts[i].trim(),value);
                            if(SaveResults(specimen_id, mID,value))
                            {
                                flag = true;
                            }
                        }

                    }
                    
                    ///now work on the calculated tests and send to BLIS
                    for(int i=0;i<calctestIDs.size();i++)
                    {
                        mID = getMeasureID(calctestIDs.get(i).split(";")[0].trim());
                        if(mID > 0)
                        {
                            try
                            {
                                ScriptEngineManager mgr = new ScriptEngineManager();
                                ScriptEngine engine = mgr.getEngineByName("JavaScript");                               
                                
                                value = Float.parseFloat(String.valueOf(engine.eval(calctestIDs.get(i).split(";")[1])));
                            }catch(NumberFormatException e){
                                value = 0;
                            } catch (ScriptException ex) {
                                log.logger.Logger("Could not perform calculation:"+calctestIDs.get(i).split(";")[1]);
                                //log.logger.PrintStackTrace(ex);
                                value = 0;
                            }
                            //PrepareCalcTests(DataParts[i].trim(),value);
                            if(SaveResults(specimen_id, mID,value))
                            {
                                flag = true;
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
      private void setCalcTestIDs()
     {
         String equipmentid = getSpecimenFilter(5);
         String formula = getSpecimenFilter(6);
        
         String[] equipmentids = equipmentid.split(",");
         String[] formulas = formula.split(",");
         for(int i=0;i<equipmentids.length;i++)
         {
             calctestIDs.add(equipmentids[i]+";"+formulas[i]);             
         }
        
     }    
    
    private static String getSpecimenFilter(int whichdata)
    {
        String data = "";
        xmlparser p = new xmlparser("configs/flexorE/flexore.xml");
        try {
            data = p.getMicros60Filter(whichdata);           
        } catch (Exception ex) {
            Logger.getLogger(FlexorE.class.getName()).log(Level.SEVERE, null, ex);
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
     
      private static void PrepareCalcTests(String equipmentID, float value)
     {
        // int measureid = 0;
         List<String> temp = new ArrayList<>();
         
         for(int i=0;i<calctestIDs.size();i++)
         {
             String temp2=calctestIDs.get(i).replaceAll(equipmentID, String.valueOf(value)); 
             temp.add(temp2);                        
             
         }  
         calctestIDs = temp;
        
     }
     
    private static boolean SaveResults(String barcode,int MeasureID, float value)
     {
         
         
          boolean flag = false;       
          if("1".equals(BLIS.blis.saveResults(barcode,MeasureID,value,2)))
           {
              flag = true;
            }
                          
         return flag;
         
     }
    
       
}
