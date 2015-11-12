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

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class utility {
    
    
    public static String hexToASCII(String hex)
    {        
          if(hex.length()%2 != 0)
          {
             System.err.println("requires EVEN number of chars");
             return null;
          }
          StringBuilder sb = new StringBuilder();                
          //Convert Hex 0232343536AB into two characters stream.
          for( int i=0; i<hex.length()-1; i+=2 )
          {
               /*
                * Grab the hex in pairs
                */
              String output = hex.substring(i, (i + 2));
              /*
               * Convert Hex to Decimal
               */
              int decimal = Integer.parseInt(output, 16);                  
              sb.append((char)decimal);              
          }            
          return sb.toString();
    } 
    
    public static String asciiToHex(String ascii)
    {
        StringBuilder hex = new StringBuilder();
        
        for (int i=0; i < ascii.length(); i++) {
            hex.append(Integer.toHexString(ascii.charAt(i)));
        }       
        return hex.toString();
    } 
    
    
}
