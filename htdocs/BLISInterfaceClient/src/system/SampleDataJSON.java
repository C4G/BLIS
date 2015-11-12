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


import BLIS.sampledata;
import com.fasterxml.jackson.core.JsonFactory;
import com.fasterxml.jackson.core.JsonParser;
import com.fasterxml.jackson.core.JsonToken;
import com.fasterxml.jackson.databind.ObjectMapper;
import hl7.Mindray.Message;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import log.DisplayMessageType;



/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class SampleDataJSON  {
    
 public static List<sampledata>  getSampleObject(String json)
  {
        List<sampledata> SampleList = new ArrayList<>();
        JsonFactory f = new JsonFactory();
        JsonParser jp;
        ObjectMapper mapper = new ObjectMapper();
     try 
     {
         jp = f.createJsonParser(json);
         jp.nextToken(); // just move to the first start of objects. This makes the while loop start
      
        
        while (jp.nextToken() == JsonToken.START_OBJECT) 
        {
            SampleList.add(mapper.readValue(jp, sampledata.class));    
        }
     } catch (IOException ex) 
     {
         Logger.getLogger(SampleDataJSON.class.getName()).log(Level.SEVERE, null, ex);
         log.AddToDisplay.Display(ex.getMessage(),DisplayMessageType.ERROR);
         log.logger.Logger(ex.getMessage());
     }
       
     return SampleList;
  }

    
 public static List<sampledata> normaliseResults(List<sampledata> data)
 {
     hl7.Mindray.Message msg = new Message();
     return msg.normaliseResults(data);
 }
}
