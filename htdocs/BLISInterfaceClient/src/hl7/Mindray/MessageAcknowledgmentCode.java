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
public enum MessageAcknowledgmentCode {
    
    OK_DATA_FOUND("OK"),
    OK_NODATA_FOUND("NF"),
    ACCEPTED("AA"),
    MESSAGE_ACCEPTED("AA",0,"Message accepted","Succeed"),
    ERROR("AE"),
    ERROR_SEQUENCE_SEGMENT("AE",100,"Segment sequence error",
            "Segment sequence is incorrect or required segment is missed"),
    ERROR_REQUIRED_FIELD("AE",101,"Required field missing","Required field in a segment is missed"),
    ERROR_DATA_TYPE("AE",102,"Data type error","Data type of a field is incorrect."),
    ERROR_TABLE_VALUE("AE",103,"Table value not found","Table value is not found, therefore not used temporarily"),            
    REJECTED("AR"),
    REJECTED_UNSOPPORTED_MESSAGE("AR",200,"Unsupported message type","Message type is not supported"),
    REJECTED_UNSUPPORTED_EVENT("AR",201,"Unsupported event code","Event code is not supported"),
    REJECTED_UNSUPPORTED_PROCESSING_ID("AR",202,"Unsupported processing id","Processing ID is not supported"),
    REJECTED_UNSUPPORTED_VERSION("AR",203,"Unsupported version id","Version ID is not supported"),
    REJECTED_UNSUPPORTED_KEY("AR",204,"Unknown key identifier",
            "Key identifier is unknown, such as inexistent patient information"),
    REJECTED_DUPPPLICATE_KEY("AR",205,"Duplicate key identifier","The key identifier already exists"),
   REJECTED_RECORD_LOCKED("AR",206,"Application record locked",
           "The transaction could not be performed at the application storage level, such as locked database"),
   REJECTED_INTERNAL_ERROR("AR",207,"Application internal error","Unknown application internal error");
   
    
    private String code;
    private int statuscode;
    private String description;
    private String statustext;
    
    private MessageAcknowledgmentCode(String code,int statuscode, String statustext,String description)
    {
        this.code= code;
        this.statuscode=statuscode;
        this.statustext=statustext;
        this.description = description;
        
    }
     private MessageAcknowledgmentCode(String code)
    {
        this.code= code;        
        
    }
    
    @Override
     public String toString()
     {
         return this.code;
     }
     
     public int getStatusCode()
     {
         return this.statuscode;
     }
     
     public String getCode()
     {
         return this.code;
     }
     public String getStatusText()
     {
         return this.statustext;
     }
     
     public String getDescription()
     {
         return this.description;
     }
}
