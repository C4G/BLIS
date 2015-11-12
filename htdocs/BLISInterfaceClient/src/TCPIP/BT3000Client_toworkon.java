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

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.Socket;
import log.logger;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public  class BT3000Client_toworkon {
    static String read;   
   public static  BufferedReader inFromEquipment=null;   
    public static Socket connSock = null;   
    public static String Equipmentname=null;
    private static final char CARRIAGE_RETURN = 13; 
    private static final char STX = 0x02;
    private static final char ACK = 0x06;
    private static final char EOT = 0x04;
    private static final char NAK = 0x15;
    private static final char NUL = 0x00;
    private static final char ENQ = 0x05;
    private static final char ETX = 0x03;
    boolean on = false;
   

   
    public  static void  run() {
       try
       {
          System.out.println("Client instance created");
         log.AddToDisplay.Display("Client instance created", log.DisplayMessageType.INFORMATION);
         logger.Logger("Client instance created");
           String input ="";
            while(true)
            {
                try
                {
                  inFromEquipment=new BufferedReader(new InputStreamReader (connSock.getInputStream()));
                 
                    read = "";
                    int c=0;
                        int val;
                        String line ="";
                        while((val = inFromEquipment.read()) > -1)
                        {                     
                          if(val != 13)
                          {
                            line = line + (char)val;  
                             if((char)val == ACK || (char)val == ENQ || (char)val == NAK || (char)val == EOT || (char)val == ETX)
                             {
                                 read = read + line;
                                 break;
                             }
                                 
                          }
                          else
                          {
                             line = line + "\r";
                             read = read + line;
                             if(line.startsWith("L|1|N"))
                                 break;                            
                             line ="";                             
                             c++;
                          }
                          /*if(c>=29)
                              break;*/
                        }
               
                 
                }catch(NullPointerException ex){
                     log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
                }                  
                 
                  if(!read.isEmpty())
                  {
                    log.AddToDisplay.Display("New message recieved", log.DisplayMessageType.TITLE);     
                    log.AddToDisplay.Display(read, log.DisplayMessageType.INFORMATION);         
                    system.utilities.writetoFile(read.replaceAll("<::>", "\r"));
                  
                   BT3000PlusChameleon.handleMessage(read);
                  }
                            
            }
           
       }catch(IOException e){
           logger.Logger(e.getMessage());
           log.AddToDisplay.Display(e.getMessage(), log.DisplayMessageType.ERROR);
       }
    }
    
}
