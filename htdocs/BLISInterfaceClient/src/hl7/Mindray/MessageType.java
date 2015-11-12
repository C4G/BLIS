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
package hl7.Mindray;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public enum MessageType 
{
     OBSERVE_RESULT("ORU^R01"),
     RESULT_ACKNOWLEDGED ("ACK^R01"),
     QUERY("QRY^Q02"),
     QUERY_ACKNOWLEDGED("QCK^Q02"),
     DISPLAY_RESPONSE("DSR^Q03"),
     RESPONSE_ACKNOWLEDGED("ACK^Q03");
    
     private String type;
     private MessageType(String type)
     {
         this.type = type;
     }
     
     @Override
     public String toString()
     {
         return this.type;
     }
       
}

