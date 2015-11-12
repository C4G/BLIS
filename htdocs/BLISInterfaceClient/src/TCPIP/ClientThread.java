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
import java.io.*;
import java.net.*;
import java.util.*;
import log.*;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 * 
 * This is the main client thread that handles all communication to equipment using the TCP/IP protocol
 */
class ClientThread extends Thread
{   
    String read;   
    BufferedReader inFromEquipment=null;   
    Socket connSock = null;   
    String Equipmentname=null;
    private static final char CARRIAGE_RETURN = 13; 
    private static final char STX = 0x02;
    private static final char ACK = 0x06;
    private static final char EOT = 0x04;
    private static final char NAK = 0x15;
    private static final char NUL = 0x00;
    private static final char ENQ = 0x05;
    private static final char ETX = 0x03;  
    private static final char ETB = 0x17;
    public ClientThread( Socket conn, String Equipment)
    {
         this.connSock= conn;    
         this.Equipmentname = Equipment;
         System.out.println("Client instance created");
         log.AddToDisplay.Display("Client instance created", log.DisplayMessageType.INFORMATION);
         logger.Logger("Client instance created");
         
    }
    @Override
    public void run() {
       try
       {
         
            System.out.println("Client has started");
            log.AddToDisplay.Display("Client thread has started", log.DisplayMessageType.INFORMATION);
            logger.Logger("Client thread has started");
           
           String input ="";
            while(true)
            {
                try
                {
                  inFromEquipment=new BufferedReader(new InputStreamReader (connSock.getInputStream()));
                 
                    read = "";
                    if(this.Equipmentname.equalsIgnoreCase("Mindray BS-200E"))
                    {
                        while((input = inFromEquipment.readLine()).length()> 1)
                        {

                          read = read + input + "<::>";   
                             //count++;
                        }
                    }
                    else if (this.Equipmentname.equalsIgnoreCase("SYSMEX XS-500I") || this.Equipmentname.equalsIgnoreCase("COBASAMPLIPREP") )
                    {
                        int c=0;
                        int val;
                        String line ="";
                        while((val = inFromEquipment.read()) > -1)
                        {                     
                          if(val != 13)
                            line = line + (char)val;   
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
                    }
                    else if(this.Equipmentname.equalsIgnoreCase("BT3000PlUSChameleon") || this.Equipmentname.equalsIgnoreCase("SYSMEX XT-2000i"))
                    {
                        int c=0;
                        int val;
                        String line ="";
                        while((val = inFromEquipment.read()) > -1)
                        {                     
                          if(val != 13)
                          {
                            line = line + (char)val; 
                           // log.AddToDisplay.Display((char)val+"",0);
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
                    }
                    else if(this.Equipmentname.equalsIgnoreCase("GENEXPERT"))
                    {
                        int c=0;
                        int val;
                        String line ="";
                        while((val = inFromEquipment.read()) > -1)
                        { if(val != 13)
                          {
                            line = line + (char)val;  
                             if((char)val == ACK || (char)val == ENQ || (char)val == NAK || (char)val == EOT || (char)val == ETX|| (char)val == ETB)
                             {
                                 read = read + line;
                                 break;
                             }
                                 
                          }
                          else
                          {
                             line = line + "\r";
                             read = read + line;                                                       
                             line ="";                             
                             c++;
                          }                            
                        }
                    }
                    else if (this.Equipmentname.equalsIgnoreCase("FLEXOR JUNIOR"))
                    {
                        int c=0;
                        int val;
                        String line ="";
                        while((val = inFromEquipment.read()) > -1)
                        {                     
                          if(val != 13)
                            line = line + (char)val;   
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
                    }
                    else
                    {
                        while((input = inFromEquipment.readLine())!= null)
                        {

                          read = read + input + "\r";   
                             //count++;
                        }
                    }
               
                 
                }catch(NullPointerException ex){
                     log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
                }                  
                 
                  if(!read.isEmpty())
                  {
                    log.AddToDisplay.Display("New message recieved", log.DisplayMessageType.TITLE);     
                    log.AddToDisplay.Display(read, log.DisplayMessageType.INFORMATION);         
                    system.utilities.writetoFile(read.replaceAll("<::>", "\r"));
                  
                    switch(this.Equipmentname)
                    {
                        case "Mindray BS-200E":
                            MindrayBS200E.handleMessage(read);
                            break;
                        case "BT3000PlUSChameleon":
                            BT3000PlusChameleon.handleMessage(read);
                            break;
                        case "SYSMEX XS-500i":
                            SYSMEXXS500i.handleMessage(read);
                            break;
                        case "FLEXOR JUNIOR":
                            FlexorJunior.handleMessage(read);
                            break;
                        case "CobasAmpliPrep":
                            CobasAmpliPrep.handleMessage(read);
                            break;
                        case "GENEXPERT":
                            GeneXpert.handleMessage(read);
                            break;
                        case "SYSMEX XT-2000i":
                            SYSMEXXT2000i.handleMessage(read);
                            break;
                    }   
                  }
                            
            }
           
       }catch(IOException e){
           logger.Logger(e.getMessage());
           log.AddToDisplay.Display(e.getMessage(), log.DisplayMessageType.ERROR);
       }
    }
    
}
