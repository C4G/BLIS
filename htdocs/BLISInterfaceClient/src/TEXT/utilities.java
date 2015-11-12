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
public class utilities {
    
    public String getFileName(String Format,String extension)
    {
       String name = "";
       if(!Format.contains("*"))
            name = system.utilities.getSystemDate(Format);
        if(null == extension || extension.isEmpty()) 
            return name;
        else
            return name +"."+extension;        
        
    }
    
}
