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
package configuration;


import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 * 
 * Configuration for data elements in the main configuration file (BLISInterfaceClient.ini)
 */
public class configuration {
    
    public static String CONFIG_FILE = "BLISInterfaceClient.ini";
    public static final String FEED_SOURCE = "FEED SOURCE";//TCP/IP,RS232,HTTP
    public static final String RS232_CONFIGURATIONS = "RS232 CONFIGURATIONS";
    public static final String TCP_IP_CONFIGURATIONS = "TCP/IP CONFIGURATIONS";
    public static final String MSACCESS_CONFIGURATIONS = "MSACCESS CONFIGURATIONS";
    public static final String TEXT = "TEXT";
    public static final String DATASOURCE = "DATASOURCE";
    public static final String DAYS = "DAYS";
    public static final String BLIS_CONFIGURATIONS = "BLIS CONFIGURATIONS";
    public static final String MISCELLANEOUS = "MISCELLANEOUS";
    public static final String EQUIPMENT = "EQUIPMENT";
    public static final String COMPORT = "COMPORT";
    public static final String BAUD_RATE = "BAUD_RATE";
    public static final String PARITY = "PARITY";
    public static final String STOP_BITS = "STOP_BITS";
    public static final String DATA_BITS = "DATA_BITS";
    public static final String INCLUDE_NEWLINE ="INCLUDE_NEWLINE";
    public static final String INCLUDE_CARRIAGE_RETURN ="INCLUDE_CARRIAGE_RETURN";
    public static final String BLIS_URL ="BLIS_URL";
    public static final String BLIS_USERNAME ="BLIS_USERNAME";
    public static final String BLIS_PASSWORD ="BLIS_PASSWORD";
    public static final String PORT ="PORT";
    public static final String EQUIPMENT_IP ="EQUIPMENT_IP";
    public static final String COMMENT_CHAR =";";
    
    
    public static String GetParameterValue(String param)
    {        
        
        File config_file = new File(CONFIG_FILE);
        Scanner scanner = null;
        try {
            scanner = new Scanner(config_file);
        } catch (FileNotFoundException ex) {
            Logger.getLogger(configuration.class.getName()).log(Level.SEVERE, null, ex);
        }
        String newLine;
       // newLine.
        String nextLine = "";
        String line="";
        while(scanner.hasNextLine())
        {
            newLine = scanner.nextLine().trim();            
            if(newLine.startsWith(COMMENT_CHAR) || newLine.isEmpty())
               continue;
            if(newLine.equalsIgnoreCase((new StringBuilder()).append("[").append(param).append("]").toString()))
            {               
                 while(scanner.hasNextLine())
                 {
                     line = scanner.nextLine().trim();                     
                     if(line.startsWith(COMMENT_CHAR) || line.isEmpty())
                         continue;                     
                     if(!line.endsWith("]") && !line.startsWith("["))
                     {
                         nextLine +=line+",";
                     }
                     else
                     {
                         break;
                     }
                 }
            }
        }
              
       if(nextLine.endsWith(","))
           nextLine=nextLine.substring(0, nextLine.length()- 1);
        return nextLine.trim();
     
    }    
    
}



