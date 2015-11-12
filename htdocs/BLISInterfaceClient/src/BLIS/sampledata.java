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
package BLIS;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 * 
 * Data elements that will be retrieved from BLIS
 */
public class sampledata {
    
    public String specimen_id;
    public String aux_id;
    public String date_collected;
    public String date_recvd;
    public String doctor;
    public String name;
    public String surr_id;
    public String sex;
    public String dob;
    public String result;
    public String test_type_id;   
    public String testname;
    public String specimen_type_id;
    public String specimentype;
    public String measure_id;
    public String partial_dob;
    
    @Override
    public String toString()
    {
        return aux_id;
    }
    
}
