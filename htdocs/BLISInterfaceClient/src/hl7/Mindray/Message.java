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

import BLIS.sampledata;
import java.util.ArrayList;
import java.util.List;
import hl7.blocks;
import system.utilities;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class Message {
    
     //get and setters are a waste of time for me
    public String type;
    public String description;
    public String initiator;
    public String replymessage;
    public String responseto;
    public String follow;
    public List<Segment> Segments = new ArrayList<>();  
    
    
    public void setValue(String segmentName, int position, String value)
    {
        for(int i=0;i<this.Segments.size();i++)
          {
              if(this.Segments.get(i).name.equalsIgnoreCase(segmentName))
              {
                  for(int j=0;j<this.Segments.get(i).Fields.size();j++)
                  {
                      if(this.Segments.get(i).Fields.get(j).position == position )
                      {
                           this.Segments.get(i).Fields.get(j).realValue= value;
                           break;
                      }
                  }
                  break;                 
              }
          }
    }
    
    public String getValue(String segmentName, int position)
    {
        String value="";
        
        for(int i=0;i<this.Segments.size();i++)
          {
              if(this.Segments.get(i).name.equalsIgnoreCase(segmentName))
              {
                  for(int j=0;j<this.Segments.get(i).Fields.size();j++)
                  {
                      if(this.Segments.get(i).Fields.get(j).position == position )
                      {
                           value = this.Segments.get(i).Fields.get(j).realValue;
                           break;
                      }
                  }
                  break;                 
              }
          }
        
        return value;
    }
    
    public String getValue(Segment segment, int position)
    {
        String value = "";
        for(int j=0;j<segment.Fields.size();j++)
        {
            if(segment.Fields.get(j).position == position )
            {
                value = segment.Fields.get(j).realValue;
                break;
            }
       }            
                 
        return value;
    }
    
    private String getHL7Segment(Segment seg)
    {
        StringBuilder value = new StringBuilder();      
        value.append(seg.name);
        int i = 1;
        if(seg.name.equalsIgnoreCase("MSH"))
            i = 2;
        
        for(;i<=seg.fieldlength;i++)
        {
            String field = getValue(seg,i);
            if(field.isEmpty())
                 value.append("|");
            else
                value.append("|").append(field);
        }
        
        value.append("|");
        return value.toString();
    }
    
    public String getHL7Message()
    {      
        
         StringBuilder Messagebuff = new StringBuilder();         
	 Messagebuff.append(blocks.START_OF_BLOCK);
         for(int i=0;i<this.Segments.size();i++)
         {
              Messagebuff.append(getHL7Segment(this.Segments.get(i)));
              Messagebuff.append(blocks.CARRIAGE_RETURN);
              
         }      
		
	
	 Messagebuff.append(blocks.END_OF_BLOCK);
	 Messagebuff.append(blocks.CARRIAGE_RETURN);
                         
        return Messagebuff.toString();
    }
    
    public List<String> getHL7Message(List<sampledata> results)
    {
         List<String> messages = new ArrayList<>();
         StringBuilder Messagebuff = new StringBuilder();
         List<sampledata> normalisedResults = normaliseResults(results);
         for(int k=0;k<normalisedResults.size();k++)
         {
            Messagebuff.append(blocks.START_OF_BLOCK);
            for(int i=0;i<this.Segments.size();i++)
            {
                this.Segments.get(0).Fields.get(6).realValue = Integer.toString(i+1);
                 Messagebuff.append(getHL7Segment(this.Segments.get(i)));
                 Messagebuff.append(blocks.CARRIAGE_RETURN);              
            }
            for(int dsp=1; dsp <= 29; dsp++)
            {
                if(dsp == 2 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).specimen_id).append("|||"); 
                else if(dsp == 3 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).name).append("|||"); 
                else if(dsp == 4 ) 
                    Messagebuff.append("DSP|").append(dsp).append("||").append(utilities.getHL7Date(normalisedResults.get(k).dob,normalisedResults.get(k).partial_dob, "yyyyMMddHHmmss")).append("|||"); 
                else if(dsp == 5 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).sex).append("|||"); 
                else if(dsp == 21 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).aux_id).append("|||"); 
                else if(dsp == 22 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).specimen_type_id.split(",")[0]).append("|||"); 
                else if(dsp == 23 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(utilities.getSystemDate("yyyyMMddHHmmss")).append("|||"); 
                else if(dsp == 24 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append("N").append("|||"); 
                else if(dsp == 26 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).specimentype.split(",")[0]).append("|||"); 
                else if(dsp == 27 )
                    Messagebuff.append("DSP|").append(dsp).append("||").append(normalisedResults.get(k).doctor).append("|||"); 
                else if(dsp == 29 )
                {
                    String[] testidpart = normalisedResults.get(k).measure_id.split(",");
                    //String [] testnamepart = normalisedResults.get(k).testname.split(",");
                    for(int mt =0,tid=29; mt < testidpart.length;mt++,tid++)
                    { 
                        
                        Messagebuff.append("DSP|").append(tid).append("||").append(testidpart[mt]).append("^^^").append("|||"); 
                        Messagebuff.append(blocks.CARRIAGE_RETURN);
                    }
                }
                else 
                    Messagebuff.append("DSP|").append(dsp).append("||").append("|").append("||");                
                    
                    if(dsp < 29)
                        Messagebuff.append(blocks.CARRIAGE_RETURN);
                
            }
            
            if(k < normalisedResults.size()-1)
                 Messagebuff.append("DSC|").append(k+1).append("|");
            else
                Messagebuff.append("DSC|").append("|");
            
            
            Messagebuff.append(blocks.CARRIAGE_RETURN);
            Messagebuff.append(blocks.END_OF_BLOCK);
            Messagebuff.append(blocks.CARRIAGE_RETURN);

            messages.add(Messagebuff.toString());
         
        }
         
                
	
        
        return messages;
    }
    
    public List<sampledata> normaliseResults(List<sampledata> data)
    {
         List<sampledata> results = new ArrayList<>();
         sampledata sample  = null;
         int sameid = -1; 
         for(int i=0;i<data.size();i++)
         {   
             sameid = inResults(results, data.get(i).specimen_id);
             if( sameid > -1)
             {
                results.get(sameid).measure_id  = results.get(sameid).measure_id + "," + data.get(i).measure_id;
                results.get(sameid).testname  = results.get(sameid).testname + "," + data.get(i).testname;
                results.get(sameid).specimentype  = results.get(sameid).specimentype + "," + data.get(i).specimentype;
                results.get(sameid).specimen_type_id  = results.get(sameid).specimen_type_id + "," + data.get(i).specimen_type_id;
                
             }
             else
             {               
               
                sample = new sampledata();            
                sample.specimen_id = data.get(i).specimen_id;             
                sample.aux_id = data.get(i).aux_id;
                sample.date_collected = data.get(i).date_collected;
                sample.date_recvd = data.get(i).date_recvd;
                sample.dob = data.get(i).dob;
                sample.doctor = data.get(i).doctor;
                sample.name = data.get(i).name;
                //sample.result = data.get(i).result; results not needed for minday hl7 messages
                sample.sex = data.get(i).sex;
                sample.surr_id = data.get(i).surr_id;
                sample.specimentype = data.get(i).specimentype;
                sample.specimen_type_id = data.get(i).specimen_type_id;
                sample.test_type_id = data.get(i).test_type_id;
                sample.testname = data.get(i).testname;
                sample.measure_id = data.get(i).measure_id;
                sample.partial_dob = data.get(i).partial_dob;
                results.add(sample);
             }
             
         }
         
         return results;
    }
    
    private int inResults(List<sampledata> data, String specimenid)
    {
        int in = -1;
        for(int i=0;i<data.size();i++)
        {
            if(specimenid.equals(data.get(i).specimen_id))
            {
                in = i;
                break;
            }
        }
        return in;
    }
    
}
