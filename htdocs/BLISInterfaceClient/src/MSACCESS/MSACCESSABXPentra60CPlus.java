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
package MSACCESS;

import BLIS.sampledata;
import configuration.configuration;
import static configuration.configuration.CONFIG_FILE;
import configuration.xmlparser;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Locale;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import log.DisplayMessageType;
import system.SampleDataJSON;
import system.settings;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 * 
 * Main handler for ABX Pentra 60 C+ Analyzer
 * Connects directly to MSACCESS database to achieve 2-way communication
 */
public class MSACCESSABXPentra60CPlus  extends Thread {
    
         
     private PentraDatabaseHandler con = null;
     private  List<String> testIDs = new ArrayList<String>();
     private boolean stopped = false;
     
     @Override
     public void run()
     {
         con = new PentraDatabaseHandler();
         log.AddToDisplay.Display("ABX Pentra 60 C+ Handler Started",log.DisplayMessageType.TITLE);
         if(con.testConnection())
         {
             log.AddToDisplay.Display("Sucessfully connected to ABX Pentra 60 C+",log.DisplayMessageType.INFORMATION);
         }
         else
         {
             log.AddToDisplay.Display("Error: Could not connect to ABX Pentra 60 C+",log.DisplayMessageType.ERROR);
         }         
         setTestIDs();
         if(settings.ENABLE_AUTO_POOL)
         {
            while(!stopped)
            {             
                try {
                    getBLISTests("",false);
                    manageResults();
                    Thread.sleep(settings.POOL_INTERVAL * 1000);
                } catch (InterruptedException ex) {
                    Logger.getLogger(MSACCESSABXPentra60CPlus.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
            log.AddToDisplay.Display("ABX Pentra 60 C+ Handler Stopped",log.DisplayMessageType.TITLE);
         }
         else
         {
             log.AddToDisplay.Display("Auto Pull Disabled. Only manual activity can be performed",log.DisplayMessageType.INFORMATION);
         }
     }
     
     public void Stop()
     {
         
         log.AddToDisplay.Display("Stopping Handler Please wait...",log.DisplayMessageType.TITLE);
         stopped = true;          
         try
         {
         super.interrupt();
         }catch(Exception e){}
        
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
     
     public void getFromBlis(String barcode)
     {   
          con = new PentraDatabaseHandler();
         getBLISTests(barcode,true);
        
     }
     
     public void sendToBlis(String barcode)
     {
          con = new PentraDatabaseHandler();
           setTestIDs();
         if(getAndSaveResults(barcode))
         {
             log.AddToDisplay.Display("Sent results of Barcode:"+barcode+" to BLIS sucessfully",log.DisplayMessageType.INFORMATION);
         }
         else
          {
              log.AddToDisplay.Display("Error: Could not send results of Barcode:"+barcode+" to BLIS!",log.DisplayMessageType.ERROR);
          }
     }
     
     private void manageResults()
     {
           List<String> barcodes = getQueue();
           List<String> maintainbarcodes = new ArrayList<>();
           for(int i=0;i<barcodes.size();i++)
           {
               
               if(!getAndSaveResults(barcodes.get(i)))
               {
                   maintainbarcodes.add(barcodes.get(i));                   
               }
               else
               {
                   log.AddToDisplay.Display("Sent results of Barcode:"+barcodes.get(i)+" to BLIS sucessfully",log.DisplayMessageType.INFORMATION);
               }
           }           
          addToQueue(maintainbarcodes);
           
     }
     
     private boolean getAndSaveResults(String barcode)
     {
         //todo
         boolean flag = false;
         List<Result> results = con.getResult(barcode);
         for(int i=0;i<results.size();i++)
         {
             results.get(i).measureID = getMeasureID(results.get(i).equipmentID);
             if("1".equals(BLIS.blis.saveResults(barcode,results.get(i).measureID,results.get(i).result,2)))
             {
                 flag = true;
             }
         }                    
         return flag;
         
     }
     
     private int getMeasureID(int equipmentID)
     {
         int measureid = 0;
         for(int i=0;i<testIDs.size();i++)
         {
             if(testIDs.get(i).split(";")[0].equalsIgnoreCase(String.valueOf(equipmentID)))
             {
                 measureid = Integer.parseInt(testIDs.get(i).split(";")[1]);
                 break;
             }
         }
         
         return measureid;
     }
     private void getBLISTests(String aux_id, boolean flag)
     {
         try
         {
         String data = BLIS.blis.getTestData(getSpecimenFilter(2), getSpecimenFilter(1),aux_id);
         List<sampledata> SampleList = SampleDataJSON.getSampleObject(data);
         if(SampleList.size() > 0)
         {            
             for (int i=0;i<SampleList.size();i++) 
             {                 
                 if(!con.testExist(SampleList.get(i).aux_id))
                 {
                    // log.AddToDisplay.Display(SampleList.size()+" result(s) test found in BLIS!",DisplayMessageType.INFORMATION);
                     //log.AddToDisplay.Display("Sending test to Analyzer",DisplayMessageType.INFORMATION);
                     log.AddToDisplay.Display("Sending test with BARCODE: "+SampleList.get(i).aux_id + " to Analyzer ABX Pentra 60 C+",DisplayMessageType.INFORMATION);
                     if(saveToPentra(SampleList.get(i)))
                     {
                         addToQueue(SampleList.get(i).aux_id);
                         log.AddToDisplay.Display("Test sent sucessfully",DisplayMessageType.INFORMATION);
                     }
                 }
                 else
                 {
                     if(flag)                         
                         log.AddToDisplay.Display("Sample with barcode: "+aux_id +" already exist in Analyzer",DisplayMessageType.INFORMATION);
                 }
             }
             
         }
          else
           {
              if(flag)                         
                log.AddToDisplay.Display("Sample with barcode: "+aux_id +" does not exist in BLIS",DisplayMessageType.INFORMATION);
          }
         }catch(Exception ex)
         {
             log.logger.PrintStackTrace(ex);
         }
     }
     
     
     private boolean addToQueue(String SampleBarcode)
     {
         boolean flag = false;
         try
        {           
            PrintWriter printWriter;
            try (FileWriter fileWriter = new FileWriter(new File("configs/pentra/queue.txt"), true)) {
                printWriter = new PrintWriter(fileWriter);
                printWriter.println(SampleBarcode);                           
            }
            printWriter.close();
            flag = true;
        }
        catch(Exception ex) { 
            log.logger.Logger(ex.getMessage());
            flag = false;
        }
         
         
         return flag;
     }
     
     private boolean addToQueue(List<String> barcodes)
     {
         boolean flag = false;
         try
        {           
            PrintWriter printWriter;
            try (FileWriter fileWriter = new FileWriter(new File("configs/pentra/queue.txt"))) {
                printWriter = new PrintWriter(fileWriter);
                printWriter.print("");
                for(int i=0;i<barcodes.size();i++)
                {
                    printWriter.println(barcodes.get(i));
                }
            }
            printWriter.close();
            flag = true;
        }
        catch(Exception ex) { 
            log.logger.Logger(ex.getMessage());
            flag = false;
        }
         
         
         return flag;
     }
     private List<String> getQueue()
     {
         List<String> barcode = new ArrayList<>();
         
        File config_file = new File("configs/pentra/queue.txt");
        Scanner scanner = null;
        try {
            scanner = new Scanner(config_file);
        } catch (FileNotFoundException ex) {
            Logger.getLogger(configuration.class.getName()).log(Level.SEVERE, null, ex);
        }
        String code="";
        while(scanner.hasNextLine())
        {
            code = scanner.nextLine().trim();
            if(!code.isEmpty())
            {
                barcode.add(code); 
            }
        }
        return barcode;         
     }
     private boolean saveToPentra(sampledata data )
     {
          return con.save(data);       
     }
     
     private static String getSpecimenFilter(int whichdata)
    {
        String data = "";
        xmlparser p = new xmlparser("configs/pentra/pentra60cplus.xml");
        try {
            data = p.getPentraFilter(whichdata);           
        } catch (Exception ex) {
            Logger.getLogger(MSACCESSABXPentra60CPlus.class.getName()).log(Level.SEVERE, null, ex);
        }        
        return data;        
    }
     
 class PentraDatabaseHandler
 {
     Connection con; // The connection to the database.
     
     private int getPrescriptor(String doctorName)
     {
         if(doctorName.length() > 15)
            doctorName = doctorName.substring(0,15);
         int Id =0;
         try{
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
            // Fetch table
            String sql = "SELECT PRESCRIPTOR FROM  PRESCRIPTOR where PRESCRIPTOR_NOM='"+doctorName+"'";
            stmt.execute(sql);
            ResultSet rs = stmt.getResultSet();
            if((rs!=null) && (rs.next()))
            {
               Id = Integer.parseInt(rs.getString("PRESCRIPTOR"));
            }
            else
            {
               
                sql="insert into PRESCRIPTOR(PRESCRIPTOR_NOM) values ('"+doctorName+"')";
                stmt.executeUpdate(sql);
                stmt.close();
                return  getPrescriptor(doctorName);        
            }
            rs.close();
            con.close();
        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
       
        }
         
         return Id;
         
     }
     
     private int getNewSequenceNum()
     {
         int Id =0;
         try{
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
            // Fetch table
            String sql = "SELECT MAX(SEQ_NUMBER)AS NUM FROM tmpWorkList";
            stmt.execute(sql);
            ResultSet rs = stmt.getResultSet();
            if((rs!=null) && (rs.next()))
            {
               Id = Integer.parseInt(rs.getString("NUM"));
            }            
            rs.close();
            con.close();

        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
       
        }
         
         return Id+1;
     }
     
     private boolean testConnection()
     {
         boolean test = false;
         try{
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
            // Fetch table
            String selTable = "SELECT  * FROM  PRESCRIPTOR ";
            stmt.execute(selTable);
            ResultSet rs = stmt.getResultSet();
            if((rs!=null) && (rs.next()))
            {
                test = true;
            }
            rs.close();
            con.close();

        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
        test = false;
        }
         
         return test;
     }
             
     public boolean testExist(String no_id)
     {        
         boolean exist = false;        
         try{
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
            // Fetch table
            String selTable = "SELECT * FROM  tmpWorkList where NO_ID='"+no_id+"'";
            stmt.execute(selTable);
            ResultSet rs = stmt.getResultSet();
            if((rs!=null) && (rs.next()))
            {
                exist = true;
            }
            rs.close();
            con.close();

        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
        exist = false;
        }
         
         return exist;
     }
     
     private List<Result> getResult(String barcode)
     {
         List<Result> results = new ArrayList<>();
         try
         {
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
             String sql = "SELECT HMT.Hemato, HMT.HMT_VAL" +
                        " FROM RESULT INNER JOIN HMT ON RESULT.RESULT = HMT.RESULT" +
                        " WHERE RESULT.NO_ID ='"+barcode+"'";
            stmt.execute(sql);
            ResultSet rs = stmt.getResultSet();
            Result r = null;
            while((rs!=null) && (rs.next()))
            {
                r = new Result();
                r.aux_id = barcode;
                r.equipmentID = Integer.parseInt(rs.getString("Hemato"));
                r.result = Float.parseFloat(rs.getString("HMT_VAL"));
                
                results.add(r);
                //System.out.println(rs.getString("Hemato") + " : " + rs.getString("Libelc"));
            }
            con.close();
        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
        
        }        
         
         
         return results;
     }
     private boolean saveWorkList(int patientid,int doctorid,sampledata sample)
     {
         boolean success = false;        
         try{
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
             String sql = "insert into tmpWorkList(PATIENT,OPERATOR,NO_ID,SampleMode,SAMPLING_DATE,Test,Type,VETO,"
                     + "COLLECTING_DATE,PRESCRIPTOR,SERVICE,Mode,IDENTITY) values("
                    + "'"+patientid+"',1,"
                    + "'"+ sample.aux_id+"',"
                    + "'1',"                    
                    + "NOW(),"
                    + "2,1,0,NOW(),"
                    + "'"+doctorid+"',"
                     + "1,1,"
                     + "'"+sample.name.toUpperCase(Locale.ENGLISH)+"')";
            stmt.executeUpdate(sql);
            success = true;
            con.close();
        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
        success = false;
        }        
        
         return success;
     }
     public boolean save(sampledata sample)
     {        
         boolean success = false; 
           int doctorID = getPrescriptor(sample.doctor);
           int num = 0;
         try{
             Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
             con = DriverManager.getConnection("jdbc:odbc:"+Settings.DATASOURCE);
            // Create an SQL statement.
            Statement stmt = con.createStatement();
            // Fetch table
            String sql = "insert into PATIENT(IDENT,BIRTHDATE,SEX,PATIENT_ID) values("
                    + "'"+sample.name.toUpperCase(Locale.ENGLISH)+"',"
                    + "'"+ system.utilities.getNormalizedDate(sample.dob, sample.partial_dob)+"',"
                    + "'"+sample.sex+"',"
                    + "'"+sample.surr_id+"'"
                    + ")";
            stmt.executeUpdate(sql);
            
            sql = "SELECT MAX(PATIENT)AS NUM FROM PATIENT";
            stmt.execute(sql);
            ResultSet rs = stmt.getResultSet();
            if((rs!=null) && (rs.next()))
            {
               num = Integer.parseInt(rs.getString("NUM"));
            }           
            rs.close();
           con.close();
            
            success = saveWorkList(num,doctorID,sample);
        }
        // Catch any exceptions that are thrown.
        catch(ClassNotFoundException | SQLException e){
        log.AddToDisplay.Display("ERROR:"+e.getMessage(),DisplayMessageType.ERROR);
        log.logger.PrintStackTrace(e);
        success = false;
        }
         
         return success;
     }
 }
    
}
