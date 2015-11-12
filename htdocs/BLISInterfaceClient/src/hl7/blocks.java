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
package hl7;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class blocks {
   public  static final char END_OF_BLOCK = '\u001c'; 
   public static final char START_OF_BLOCK = '\u000b';
   public static final char CARRIAGE_RETURN = 13; 
   public  static final int END_OF_TRANSMISSION = -1;
   public static final String FIELD_SEPRETOR ="\\|";
   public static final String COMPONENT_SEPRETOR ="^";
   public static final String SUB_COMPONENT_SEPRETOR ="&";
   public static final String REPITITION_STRING ="~";
   public static final String ESCAPE_STRING ="\\";
   public static final String BLIS_MANUFACTURER ="GHSS";
   public static final String BLIS_MODEL ="BLIS";
   
   
   
    
}
