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

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class Segment {
    public String name;
    public String id;
    public String description;
    public int position;
    public int fieldlength;     
    public List<Field> Fields = new ArrayList<>();
    //get and setters are a waste of time for me
}
