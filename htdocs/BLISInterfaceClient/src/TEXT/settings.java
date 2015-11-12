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
package TEXT;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class settings {
    public static String BASE_DIRECTORY;
    public static boolean USE_SUB_DIRECTORIES;
    public static String SUB_DIRECTORY_FORMAT;
    public static String FILE_NAME_FORMAT;
    public static String FILE_EXTENSION;
    public static String FILE_SEPERATOR;
    public static char SEPERATOR_CHAR;
    
    public static void setChar(String Seperator)
    {
        switch(Seperator)
        {
            case "TAB":
                SEPERATOR_CHAR = 0x09;
                break;
            case "COMMA":
                SEPERATOR_CHAR =0x2c;
                break;
            case "COLON":
                SEPERATOR_CHAR =0x3a;
                break;
            case "SEMI-COLON":
                SEPERATOR_CHAR =0x3b;
                break;
            case "SPACE":
                SEPERATOR_CHAR =0x20;
                break;
                
        }
    }
    
}
