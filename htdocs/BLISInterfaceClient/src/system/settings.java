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
package system;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class settings {
    public static String BLIS_URL;
    public static String BLIS_PASSWORD;
    public static String BLIS_USERNAME;       
    public static boolean ENABLE_LOG;
    public static boolean WRITE_TO_FILE;
    public static final String VERSION = "2.6.12";
    public static int POOL_DAY;
    public static int POOL_INTERVAL;
    public static boolean ENABLE_AUTO_POOL;
    public static boolean SERVER_MODE;
    public static boolean AUTO_SPECIMEN_ID;
}
