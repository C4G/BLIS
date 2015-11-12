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
import java.io.File;
import java.io.FileWriter;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.nio.charset.Charset;
import java.util.logging.Level;
import java.util.logging.Logger;
import jssc.*;
import log.*;
import static log.logger.getCurrentTimeStamp;
import system.settings;
import ui.MainForm;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 * 
 * This is the main handler for all equipment that are interfaced using the RS232(Com port) Protocol
 */
public class Manager  extends RS232Settings {
    
    static SerialPort DataserialPort;
   static int check =0;
   static String EquipmentName ="";
    
    public static String[] getSerialPorts()
    {
       return  SerialPortList.getPortNames();        
    }
    
    public static boolean writeToSerialPort(String strData){
              boolean flag = false;
       if(APPEND_NEWLINE)
           strData = strData + "\n";
       if(APPEND_CARRIAGE_RETURN)
           strData = strData + "\r";
       
        try {          
            DataserialPort.setParams(BAUD,DATABIT_LENGTH,STOPBIT,PARITY);//Set params. 
            flag = DataserialPort.writeBytes(strData.getBytes());//Write data to port            
            log.AddToDisplay.Display("Sent "+strData,DisplayMessageType.INFORMATION);
        }
        catch (SerialPortException ex) {
            System.out.println(ex);
            logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
       
       return flag;        
    }
    
    public static boolean writeToSerialPort(char charData){
       boolean flag = false;      
       StringBuffer data = new StringBuffer();
       data.append(charData);
        try {          
            DataserialPort.setParams(BAUD,DATABIT_LENGTH,STOPBIT,PARITY);//Set params. 
            flag = DataserialPort.writeBytes(data.toString().getBytes());//Write data to port  
            String charValue = data.toString();
            switch(charData)
            {              
                case 0x00:
                    charValue="<NUL>";
                    break;
                case 0x0D:
                     charValue="<CR>";
                    break;
                case 0x0A:
                     charValue="<LF>";
                    break;
                case 0x15:
                     charValue="<NAK>";
                    break;
                case 0x06:
                     charValue="<ACK>";
                    break;
                case 0x05:
                     charValue="<ENQ>";
                    break;
                case 0x04:
                     charValue="<EOT>";
                    break;
                case 0x03:
                     charValue="<ETX>";
                    break;
                case 0x02:
                     charValue="<STX>";
                    break;
               
            }
            log.AddToDisplay.Display("Sent "+charValue,DisplayMessageType.INFORMATION);
        }
        catch (SerialPortException ex) {
            System.out.println(ex);
            logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
       
       return flag;        
    }
     public static String readFromSerialPort()
     {
         String data = "";
         SerialPort serialPort = new SerialPort(COMPORT);
        try {
            serialPort.openPort();//Open serial port
            serialPort.setParams(BAUD,DATABIT_LENGTH,STOPBIT,PARITY);//Set params.
           data = serialPort.readString();//Read data from serial port
           serialPort.closePort();//Close serial port
            //buffer.
        }
        catch (SerialPortException ex) {
            System.out.println(ex);
            logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
         return data;
     }
     
     public static boolean openPort()
     {
         boolean flag = false;
          SerialPort serialPort = new SerialPort(COMPORT);
           try {
            serialPort.openPort();       
            serialPort.closePort();
            flag =true;
        }
        catch (SerialPortException ex) {            
            logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
         return flag;
     }
     
     public static boolean closeOpenedPort()
     {
         boolean flag = false;        
        try {
            DataserialPort.closePort();
            flag = true;
        } catch (SerialPortException ex) {
             logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
         return flag;
     }
     public static boolean openPortforData(String equipment)
     {
         boolean flag = false;
          Manager.EquipmentName = equipment;
         DataserialPort = new SerialPort(COMPORT);
           try {
            DataserialPort.openPort(); 
            DataserialPort.setParams(BAUD,DATABIT_LENGTH,STOPBIT,PARITY);
            int mask = SerialPort.MASK_RXCHAR + SerialPort.MASK_CTS + SerialPort.MASK_DSR;//Prepare mask
            DataserialPort.setEventsMask(mask);//Set mask
            DataserialPort.addEventListener(new SerialPortReader());//Add SerialPortEventListener            
            
            flag =true;
        }
        catch (SerialPortException ex) {            
            logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
         return flag;
     }
     
     public static boolean openPortforDataAlt(String equipment)
     {
         boolean flag = false;
          Manager.EquipmentName = equipment;
         DataserialPort = new SerialPort(COMPORT);
           try {
            DataserialPort.openPort(); 
            DataserialPort.setParams(BAUD,DATABIT_LENGTH,STOPBIT,PARITY,false,false);                          
              int mask = SerialPort.MASK_RXCHAR + SerialPort.MASK_CTS + SerialPort.MASK_DSR +
                     SerialPort.MASK_BREAK + SerialPort.MASK_RING + SerialPort.MASK_RXFLAG+ SerialPort.MASK_ERR +
                     SerialPort.MASK_RLSD + SerialPort.MASK_TXEMPTY;//Prepare mask
            DataserialPort.setEventsMask(mask);//Set mask
            DataserialPort.addEventListener(new SerialPortReader());//Add SerialPortEventListener            
            
            flag =true;
        }
        catch (SerialPortException ex) {            
            logger.Logger(ex.getMessage());
            log.AddToDisplay.Display(ex.getMessage(), log.DisplayMessageType.ERROR);
        }
         return flag;
     }
     
     /*
     * This class must implement the method serialEvent, through it we know about 
     * events that happened to our port. But we will not report on all events but only 
     * those that we put in the mask. In this case the arrival of the data and the change of 
     * status lines CTS and DSR
     */
    static class SerialPortReader implements SerialPortEventListener {

        @Override
        public void serialEvent(SerialPortEvent event) {
            if(event.isRXCHAR()){//If data is available
                //String ascii = null;              
                String buffer="" ;
                    try {
                        buffer = DataserialPort.readString();     
                        if(null != buffer)
                        {
                            // byte bytebuffer[] = DataserialPort.readBytes(event.getEventValue());                    
                             // buffer = new String(bytebuffer,cs);
                             // buffer = new String(bytebuffer);          
                              log.AddToDisplay.Display(buffer, log.DisplayMessageType.INFORMATION);
                              system.utilities.writetoFile(buffer);

                            switch(EquipmentName.toUpperCase())
                            {
                                case "ABX MICROS 60":
                                     MICROS60.HandleDataInput(buffer);
                                    break;
                                case "BT3000 PLUS":
                                    BT3000Plus.HandleDataInput(buffer);
                                    break;
                                case "SELECTRA JUNIOR":
                                    SelectraJunior.HandleDataInput(buffer);
                                    break;
                                case "ABX PENTRA 80":
                                    ABXPentra80.HandleDataInput(buffer);
                                    break;
                                case "MINDRAY BC 3600":
                                    MindrayBC3600.HandleDataInput(buffer);
                                    break;
                                case "BT3000PLUSCHAMELEON":
                                    BT3000PlusChameleon.HandleDataInput(buffer);
                                    break;
                                case "FLEXOR E":
                                    FlexorE.HandleDataInput(buffer);
                                    break;
                                    
                            }
                      
                        }
                        
                    }
                    catch (SerialPortException ex) {
                        System.out.println(ex);
                        logger.Logger(ex.getMessage());
                    } 
               
            }
            else if(event.isCTS()){//If CTS line has changed state
                if(event.getEventValue() == 1){//If line is ON
                    System.out.println("CTS - ON");
                }
                else {
                    System.out.println("CTS - OFF");
                }
            }
            else if(event.isDSR()){///If DSR line has changed state
                if(event.getEventValue() == 1){//If line is ON
                    System.out.println("DSR - ON");
                }
                else {
                    System.out.println("DSR - OFF");
                }
            }
        }
    }
        
     
}
