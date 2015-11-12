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
package configuration;

import hl7.Mindray.Field;
import hl7.Mindray.Message;
import hl7.Mindray.Segment;
import java.io.File;
import java.io.IOException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;
import hl7.blocks;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */

public class xmlparser 
{
    private String filepath;
    
    public xmlparser(String path)
    {
        this.filepath=path;
    }
   public  Message getMindrayMessage(String HL7Message)throws Exception
   {      
        SAXParserFactory parserFactor = SAXParserFactory.newInstance();
        SAXParser parser = parserFactor.newSAXParser();
        MindrayConfigHandler xml = new MindrayConfigHandler(HL7Message);
        File file = new File(this.filepath);
        parser.parse(file,xml);
    
        return xml.msg;
   }
   
   
   
   public String getMindrayFilter(int whichdata) throws Exception
   {       
        SAXParserFactory parserFactor = SAXParserFactory.newInstance();
        SAXParser parser = parserFactor.newSAXParser();
        MindrayConfigHandler xml = new MindrayConfigHandler(whichdata);
        File file = new File(this.filepath);
        parser.parse(file,xml);
       return xml.data;
   }
   
   public Message getReplyMessage(Message msg, String type) throws Exception
   {
        SAXParserFactory parserFactor = SAXParserFactory.newInstance();
        SAXParser parser = parserFactor.newSAXParser();
        MindrayConfigHandler xml = new MindrayConfigHandler(msg,type);
        File file = new File(this.filepath);
        parser.parse(file,xml);
        return xml.msg;
   }
    
   public String getPentraFilter(int whichdata) throws Exception
   {       
        SAXParserFactory parserFactor = SAXParserFactory.newInstance();
        SAXParser parser = parserFactor.newSAXParser();
        PentraConfigHandler xml = new PentraConfigHandler(whichdata);
        File file = new File(this.filepath);
        parser.parse(file,xml);
       return xml.data;
   }
   
   public String getMicros60Filter(int whichdata) throws Exception
   {       
        SAXParserFactory parserFactor = SAXParserFactory.newInstance();
        SAXParser parser = parserFactor.newSAXParser();
        Micros60ConfigHandler xml = new Micros60ConfigHandler(whichdata);
        File file = new File(this.filepath);
        parser.parse(file,xml);
       return xml.data;
   }
   public String getBT3000PLUSFilter(int whichdata) throws Exception
   {       
        SAXParserFactory parserFactor = SAXParserFactory.newInstance();
        SAXParser parser = parserFactor.newSAXParser();
        BT3000PLUSConfigHandler xml = new BT3000PLUSConfigHandler(whichdata);
        File file = new File(this.filepath);
        parser.parse(file,xml);
       return xml.data;
   }
   
 
class BT3000PLUSConfigHandler extends DefaultHandler
   {
      String data ="";
      int whichdata = 0;
      private String content = null;
      
      public BT3000PLUSConfigHandler(int which)
      {
          this.whichdata = which;
          
      }
      
      @Override
      public void startElement(String uri, String localName, 
                           String qName, Attributes attributes) 
                           throws SAXException {
          
      }
      
      @Override
      public void endElement(String uri, String localName, 
                         String qName) throws SAXException {
          
          switch(qName)
          {
              case "testtypeid":
                    if(whichdata == 1)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
              case "lissampleid":
                  if(whichdata == 2)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "equipmenttestid":
                  if(whichdata == 3)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                      
                      
                    }                 
                  break;
                case "listestid":
                  if(whichdata == 4)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "equipmentsampleid":
                  if(whichdata == 5)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
          }    
          
      }
      
      @Override
      public void characters(char[] ch, int start, int length) 
          throws SAXException {
    content = String.copyValueOf(ch, start, length).trim();
  }
      
   }

   
  
class PentraConfigHandler extends DefaultHandler
   {
      String data ="";
      int whichdata = 0;
      private String content = null;
      
      public PentraConfigHandler(int which)
      {
          this.whichdata = which;
          
      }
      
      @Override
      public void startElement(String uri, String localName, 
                           String qName, Attributes attributes) 
                           throws SAXException {
          
      }
      
      @Override
      public void endElement(String uri, String localName, 
                         String qName) throws SAXException {
          
          switch(qName)
          {
              case "testtypeid":
                    if(whichdata == 1)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
              case "lissampleid":
                  if(whichdata == 2)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "equipmenttestid":
                  if(whichdata == 3)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "listestid":
                  if(whichdata == 4)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
          }    
          
      }
      
      @Override
      public void characters(char[] ch, int start, int length) 
          throws SAXException {
    content = String.copyValueOf(ch, start, length).trim();
  }
      
   }
   


class Micros60ConfigHandler extends DefaultHandler
   {
      String data ="";
      int whichdata = 0;
      private String content = null;
      
      public Micros60ConfigHandler(int which)
      {
          this.whichdata = which;
          
      }
      
      @Override
      public void startElement(String uri, String localName, 
                           String qName, Attributes attributes) 
                           throws SAXException {
          
      }
      
      @Override
      public void endElement(String uri, String localName, 
                         String qName) throws SAXException {
          
          switch(qName)
          {
              case "testtypeid":
                    if(whichdata == 1)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
              case "lissampleid":
                  if(whichdata == 2)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "equipmenttestid":
                  if(whichdata == 3)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                      
                      
                    }                 
                  break;
                case "listestid":
                  if(whichdata == 4)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                 case "testcode":
                  if(whichdata == 5)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "formula":
                  if(whichdata == 6)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
                case "m1":
                  if(whichdata == 7)
                    {
                      if(!data.isEmpty())
                         data = data + ","+ content;
                      else
                          data =  content;
                    }
                  break;
          }    
          
      }
      
      @Override
      public void characters(char[] ch, int start, int length) 
          throws SAXException {
    content = String.copyValueOf(ch, start, length).trim();
  }
      
   }

   /**
 * The Handler for SAX Events.
 */
class MindrayConfigHandler extends DefaultHandler {

  Message msg = new Message();
  Segment seg = null;
  Field f = null;
  String content = null; 
  String[] linedmsg = null; 
  int segcounter =-1;
  
  String type = null;
  boolean flag = false;
  String data = "";
  Message firstMessage = null;
  int whichdata = 0;

    public MindrayConfigHandler(String message) 
    {       
        this.linedmsg = message.split("<::>");    
        String[] part = this.linedmsg[0].split(blocks.FIELD_SEPRETOR);    
        this.type= part[8].trim();
    }

        private MindrayConfigHandler(int whichdata) {
            this.whichdata = whichdata;
        }
        
        private MindrayConfigHandler(Message firstMessage, String type) 
        {
            this.type = type;
            this.firstMessage = firstMessage;
            
        }
  
  
  
  @Override
  //Triggered when the start of tag is found.
  public void startElement(String uri, String localName, 
                           String qName, Attributes attributes) 
                           throws SAXException {

    switch(qName)
    {     
      case "type":
          if(attributes.getValue("name").equalsIgnoreCase(type))
          {
            msg.type = attributes.getValue("name");
            msg.description = attributes.getValue("description");
            msg.initiator = attributes.getValue("initiator");
            msg.replymessage = attributes.getValue("replymessage");
            msg.responseto = attributes.getValue("responseto");
            msg.follow = attributes.getValue("follow"); 
            flag=true;
           // System.out.println("Added "+msg.type);
          }
          break;
      case "segment": 
          if(flag)
          {
            seg = new Segment();
            seg.id= attributes.getValue("id"); 
            seg.name= attributes.getValue("name"); 
            seg.description= attributes.getValue("description"); 
            seg.fieldlength = Integer.parseInt(attributes.getValue("fieldlength"));            
            seg.position = Integer.parseInt(attributes.getValue("position"));          
            // System.out.println("Added "+seg.id);
             segcounter++;
          }         
          break; 
          case "field": 
              if(flag)
              {
                  f = new Field();
              }
              break;
          
           
          
    }
  }

  
  //triggered when an end of tag is found. This is my spot for getting my values
  @Override
  public void endElement(String uri, String localName, 
                         String qName) throws SAXException {
   switch(qName){    
     case "type":
         if(flag)
         {
             flag = false;             
         }
              
       break;
     //For all other end tags.
     case "segment":
         if(flag)
         {
             msg.Segments.add(seg);
             seg = null;
         }      
       break;
     case "field":
         if(flag)
         {
            if(seg.name.equalsIgnoreCase("MSH"))
                f.realValue = getValue(f.position - 1);
            else
                f.realValue = getValue(f.position);
            seg.Fields.add(f);            
            f = null;
         }
         //todo get realvalue from hl7 message
         break;
     case "name":
         if(flag)
         {
             f.name = content;    
         }          
       break;
     case "position":
        if(flag)
         {
             f.position = Integer.parseInt(content);    
         } 
       break;
      case "datatype":
        if(flag)
         {
             f.datatype = content;    
         } 
       break;
      case "default":
        if(flag)
         {
             f.defaultvalue = content;    
         } 
       break;
      case "format":
        if(flag)
         {
             f.format = content;    
         } 
       break;
      case "lisid":
          if(whichdata == 1)
          {
            if(!data.isEmpty())
               data = data + ","+ content;
            else
                data =  content;
          }
         break;
      case "listestid":
          if(whichdata == 2)
          {
            if(!data.isEmpty())
               data = data + ","+ content;
            else
                data =  content;
          }
         break;
       case "equipmentid":
          if(whichdata == 3)
          {
            if(!data.isEmpty())
               data = data + ","+ content;
            else
                data =  content;
          }
         break;
   }
  }

  @Override
  public void characters(char[] ch, int start, int length) 
          throws SAXException {
    content = String.copyValueOf(ch, start, length).trim();
  }
  
  private String getValue(int position)
  {
      try
      {
      if(firstMessage == null)
      {
        String[] part = linedmsg[segcounter].split(blocks.FIELD_SEPRETOR);
        System.out.println("position:"+position+ "segcounter:"+segcounter);        
        if(position >= part.length)
            return null;
        else                
            return part[position].trim();
      }
      else
      {
          if(f.defaultvalue != null)
          {
            if(f.defaultvalue.contains("[") && f.defaultvalue.contains("]") && f.defaultvalue.contains("-"))
            {
                return getReferencedValue(f.defaultvalue);
            }
            else if(f.defaultvalue.contains("sysdatetime"))
            {
               return system.utilities.getSystemDate(f.format);
            }
            else
                return f.defaultvalue;
          }
          else
              return null;
      }
      }catch(ArrayIndexOutOfBoundsException ex){return null;}
              
  }
  
  private String getReferencedValue(String reference)
  {
      String value="";
      String[] rpart = reference.split("\\-|\\[|\\]");
      if (firstMessage.type.equalsIgnoreCase(rpart[0]))
      {
          for(int i=0;i<firstMessage.Segments.size();i++)
          {
              if(firstMessage.Segments.get(i).name.equalsIgnoreCase(rpart[1]))
              {
                  for(int j=0;j<firstMessage.Segments.get(i).Fields.size();j++)
                  {
                      if(firstMessage.Segments.get(i).Fields.get(j).position == Integer.parseInt(rpart[2]) )
                      {
                           value = firstMessage.Segments.get(i).Fields.get(j).realValue;
                           break;
                      }
                  }
                  break;                 
              }
          }
      }     
      return value;     
     
  }

}
}
