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
package ui;

import  RS232.*;
import TCPIP.*;
import MSACCESS.*;
import TEXT.BDFACSCalibur;
import java.awt.AWTException;
import java.awt.Image;
import java.awt.MenuItem;
import java.awt.PopupMenu;
import java.awt.SystemTray;
import java.awt.Toolkit;
import java.awt.TrayIcon;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;
import log.logger;
import system.*;

/**
 *
 * @author Stephen Adjei-Kyei <stephen.adjei.kyei@gmail.com>
 */
public class MainForm extends javax.swing.JFrame {

    /**
     * Creates new form MainForm
     */
    
    private String source;
    private Image iconImage;
    private SystemTray sysTray;
    private PopupMenu menu;
    private MenuItem item1;
    private MenuItem item2;
    private MenuItem item3;
    private TrayIcon trayIcon;
    
    private String blis_URL;
    private String blis_username;
    private String blis_password;    
    private String equipment;
    MindrayBS200E obj = null;
    MICROS60 abx = null;
    MSACCESSABXPentra60CPlus msaccess_abx = null;
    TCPIP.BT3000PlusChameleon btobj = null;
    RS232.BT3000PlusChameleon btRSobj = null; 
    SYSMEXXS500i sysobj = null; 
    BDFACSCalibur bdobj = null;
    SelectraJunior selobj = null;
    ABXPentra80 pentra80Obj = null;
    CobasAmpliPrep cobasObj = null;
    MindrayBC3600 minbc3600obj = null;
    GeneXpert expobj = null;
    SYSMEXXT2000i sys2000iObj = null;
    FlexorE flexObj = null;
   //public static boolean reset = false;
   public static enum RESET
   {
       WAIT,
       NOW;
   }
    
   public static RESET set= RESET.WAIT;
    public MainForm() {
        initComponents();
        initTray();
        setIconImage(Toolkit.getDefaultToolkit().getImage("net.jpg"));
    }

    private void initTray()
    {
         if (SystemTray.isSupported()) {
            sysTray = SystemTray.getSystemTray();
            
            //create icon image
            iconImage  = Toolkit.getDefaultToolkit().getImage("net.jpg");

            //create popupmenu
            menu = new PopupMenu();

            //create item
            item1 = new MenuItem("Exit");
            item2 = new MenuItem("Start");    
            item3 = new MenuItem("Hide Interface");  
            //add item to menu
            menu.add(item3);           
            menu.add(item2);
            menu.add(item1);
           

            //add action listener to the item in the popup menu
            item1.addActionListener(new ActionListener() {
               public void actionPerformed(ActionEvent e) {
                  if(JOptionPane.showConfirmDialog(null, "Are you sure you want to exit?","Confirm Action",1,JOptionPane.QUESTION_MESSAGE)== 0)
                   System.exit(0);
               }
            });
            
            item2.addActionListener(new ActionListener() {
               public void actionPerformed(ActionEvent e) {
                   manageHandlers();
               }
            });
            
             item3.addActionListener(new ActionListener() {
               public void actionPerformed(ActionEvent e) {
                   if(item3.getLabel().equalsIgnoreCase("Hide Interface"))
                   {
                       setVisible(false);
                        item3.setLabel("Show Interface");
                   }
                   else
                   {
                       setVisible(true);
                       item3.setLabel("Hide Interface");
                   }
               }
            });
            
            //create system tray icon.
            trayIcon = new TrayIcon(iconImage, "BLIS Interface Client "+settings.VERSION, menu);
            
             trayIcon.addActionListener(new ActionListener() {
               public void actionPerformed(ActionEvent e) 
               {
                  if(item3.getLabel().equalsIgnoreCase("Hide Interface"))
                   {
                       setVisible(false);
                        item3.setLabel("Show Interface");
                   }
                   else
                   {
                       setVisible(true);
                       item3.setLabel("Hide Interface");
                   }
               }
            });
            //add the tray icon to the system tray.
            try {
                sysTray.add(trayIcon);
                }
            catch(AWTException e) {
               System.out.println(e.getMessage());
            }
        }
    }
    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jSplitPane1 = new javax.swing.JSplitPane();
        jPanel1 = new javax.swing.JPanel();
        jLabel1 = new javax.swing.JLabel();
        jlblSourceType = new javax.swing.JLabel();
        jLabel2 = new javax.swing.JLabel();
        jlblblisURL = new javax.swing.JLabel();
        jPanel3 = new javax.swing.JPanel();
        jScrollPane2 = new javax.swing.JScrollPane();
        jtxtConfigs = new javax.swing.JTextArea();
        jbtnStart = new javax.swing.JButton();
        jLabel3 = new javax.swing.JLabel();
        jlblEquipment = new javax.swing.JLabel();
        jSplitPane2 = new javax.swing.JSplitPane();
        jpnlManualActivity = new javax.swing.JPanel();
        jLabel4 = new javax.swing.JLabel();
        jtxtManualBarcode = new javax.swing.JTextField();
        jbtnDownload = new javax.swing.JButton();
        jbtnSend = new javax.swing.JButton();
        jScrollPane3 = new javax.swing.JScrollPane();
        jtxtPaneDisplay = new javax.swing.JTextPane();

        setTitle("BLIS Interface Client V"+settings.VERSION);
        setResizable(false);
        addWindowFocusListener(new java.awt.event.WindowFocusListener() {
            public void windowGainedFocus(java.awt.event.WindowEvent evt) {
            }
            public void windowLostFocus(java.awt.event.WindowEvent evt) {
                formWindowLostFocus(evt);
            }
        });
        addWindowListener(new java.awt.event.WindowAdapter() {
            public void windowOpened(java.awt.event.WindowEvent evt) {
                formWindowOpened(evt);
            }
        });

        jSplitPane1.setDividerLocation(300);
        jSplitPane1.setDividerSize(3);
        jSplitPane1.setCursor(new java.awt.Cursor(java.awt.Cursor.DEFAULT_CURSOR));

        jPanel1.setBorder(javax.swing.BorderFactory.createTitledBorder("Active Configurations"));
        jPanel1.setPreferredSize(new java.awt.Dimension(200, 429));

        jLabel1.setText("Source:");

        jlblSourceType.setText("Unset");

        jLabel2.setText("BLIS URL:");

        jlblblisURL.setText("Unset");

        jPanel3.setBorder(javax.swing.BorderFactory.createTitledBorder("Source Configurations:"));

        jtxtConfigs.setEditable(false);
        jtxtConfigs.setBackground(new java.awt.Color(236, 233, 216));
        jtxtConfigs.setColumns(20);
        jtxtConfigs.setLineWrap(true);
        jtxtConfigs.setRows(8);
        jScrollPane2.setViewportView(jtxtConfigs);

        javax.swing.GroupLayout jPanel3Layout = new javax.swing.GroupLayout(jPanel3);
        jPanel3.setLayout(jPanel3Layout);
        jPanel3Layout.setHorizontalGroup(
            jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(jScrollPane2, javax.swing.GroupLayout.DEFAULT_SIZE, 267, Short.MAX_VALUE)
        );
        jPanel3Layout.setVerticalGroup(
            jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, jPanel3Layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(jScrollPane2, javax.swing.GroupLayout.DEFAULT_SIZE, 224, Short.MAX_VALUE))
        );

        jbtnStart.setText("Start");
        jbtnStart.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jbtnStartActionPerformed(evt);
            }
        });

        jLabel3.setText("Equipment:");

        jlblEquipment.setText("Unset");

        javax.swing.GroupLayout jPanel1Layout = new javax.swing.GroupLayout(jPanel1);
        jPanel1.setLayout(jPanel1Layout);
        jPanel1Layout.setHorizontalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jLabel2)
                    .addComponent(jLabel3)
                    .addComponent(jLabel1))
                .addGap(20, 20, 20)
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jlblSourceType, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jlblEquipment, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jlblblisURL, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap())
            .addComponent(jPanel3, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addGap(30, 30, 30)
                .addComponent(jbtnStart, javax.swing.GroupLayout.PREFERRED_SIZE, 142, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );
        jPanel1Layout.setVerticalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jLabel1)
                    .addComponent(jlblSourceType))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jLabel2)
                    .addComponent(jlblblisURL))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jLabel3)
                    .addComponent(jlblEquipment))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 21, Short.MAX_VALUE)
                .addComponent(jPanel3, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addComponent(jbtnStart, javax.swing.GroupLayout.PREFERRED_SIZE, 51, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(20, 20, 20))
        );

        jSplitPane1.setLeftComponent(jPanel1);

        jSplitPane2.setDividerLocation(380);
        jSplitPane2.setOrientation(javax.swing.JSplitPane.VERTICAL_SPLIT);

        jpnlManualActivity.setBorder(javax.swing.BorderFactory.createTitledBorder("Manual Activity"));
        jpnlManualActivity.setPreferredSize(new java.awt.Dimension(663, 380));
        jpnlManualActivity.setLayout(null);

        jLabel4.setText("BAR CODE:");
        jpnlManualActivity.add(jLabel4);
        jLabel4.setBounds(8, 16, 90, 30);
        jpnlManualActivity.add(jtxtManualBarcode);
        jtxtManualBarcode.setBounds(80, 20, 149, 28);

        jbtnDownload.setText("Download");
        jbtnDownload.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jbtnDownloadActionPerformed(evt);
            }
        });
        jpnlManualActivity.add(jbtnDownload);
        jbtnDownload.setBounds(240, 20, 100, 30);

        jbtnSend.setText("Send");
        jbtnSend.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jbtnSendActionPerformed(evt);
            }
        });
        jpnlManualActivity.add(jbtnSend);
        jbtnSend.setBounds(350, 20, 80, 30);

        jSplitPane2.setBottomComponent(jpnlManualActivity);

        jtxtPaneDisplay.setEditable(false);
        jScrollPane3.setViewportView(jtxtPaneDisplay);

        jSplitPane2.setLeftComponent(jScrollPane3);

        jSplitPane1.setRightComponent(jSplitPane2);

        getContentPane().add(jSplitPane1, java.awt.BorderLayout.CENTER);

        setSize(new java.awt.Dimension(926, 494));
        setLocationRelativeTo(null);
    }// </editor-fold>//GEN-END:initComponents

    private void formWindowOpened(java.awt.event.WindowEvent evt) {//GEN-FIRST:event_formWindowOpened
        // TODO add your handling code here:
        //JOptionPane.showMessageDialog(null, "Form Opened");
        getConfigurations();
        manageHandlers();
        setManualActivity();
        new ResetMan().start();
    }//GEN-LAST:event_formWindowOpened

    private void jbtnStartActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jbtnStartActionPerformed
        // TODO add your handling code here:
     manageHandlers();
             
    }//GEN-LAST:event_jbtnStartActionPerformed

    private void formWindowDeactivated(java.awt.event.WindowEvent evt) {//GEN-FIRST:event_formWindowDeactivated
        // TODO add your handling code here:
       
    }//GEN-LAST:event_formWindowDeactivated

    private void formWindowLostFocus(java.awt.event.WindowEvent evt) {//GEN-FIRST:event_formWindowLostFocus
        // TODO add your handling code here:
        setVisible(false);
        item3.setLabel("Show Interface");
    }//GEN-LAST:event_formWindowLostFocus

    private void jbtnDownloadActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jbtnDownloadActionPerformed
        // TODO add your handling code here:
        if(!jtxtManualBarcode.getText().isEmpty())
            downloadFromBlis();
    }//GEN-LAST:event_jbtnDownloadActionPerformed

    private void jbtnSendActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jbtnSendActionPerformed
        // TODO add your handling code here:
        if(!jtxtManualBarcode.getText().isEmpty())
        sendToBlis();
    }//GEN-LAST:event_jbtnSendActionPerformed

    private void manageHandlers()
    {
      if (jbtnStart.getText().equalsIgnoreCase("Start"))
      {
        startAppropriateHandler();
        jbtnStart.setText("Stop");
        item2.setLabel("Stop");
      }
      else
      {   
          stopAppropriateHandler();
          jbtnStart.setText("Start");
          item2.setLabel("Start");
      }
    }
    
    private void downloadFromBlis()
    {
        switch(jlblSourceType.getText())
        {
            case "RS232":
                switch(jlblEquipment.getText())
                {
                    case "ABX Pentra 80":
                        log.AddToDisplay.Display("Manual Download from BLIS Sample Code:"+jtxtManualBarcode.getText(),log.DisplayMessageType.TITLE);                     
                       new ABXPentra80().getFromBlis(jtxtManualBarcode.getText());                 
                        break;
                }
            case "TCP/IP":
                switch(jlblEquipment.getText())
                {
                    case "BT3000 Plus-Chameleon":                        
                       log.AddToDisplay.Display("Manual Download from BLIS Sample Barcode:"+jtxtManualBarcode.getText(),log.DisplayMessageType.TITLE);                     
                       new TCPIP.BT3000PlusChameleon().getFromBlis(jtxtManualBarcode.getText());
                        break;
                    case "Cobas AmpliPrep":
                         log.AddToDisplay.Display("Manual Download from BLIS Sample Barcode:"+jtxtManualBarcode.getText(),log.DisplayMessageType.TITLE);                     
                        new CobasAmpliPrep().getFromBlis(jtxtManualBarcode.getText());
                        break;
                }
                break;
             case "MSACCESS":
                switch(jlblEquipment.getText())
                {
                    case "ABX Pentra 60C+":    
                        log.AddToDisplay.Display("Manual Download from BLIS Sample Barcode:"+jtxtManualBarcode.getText(),log.DisplayMessageType.TITLE);
                     new MSACCESSABXPentra60CPlus().getFromBlis(jtxtManualBarcode.getText());
                        break;
                }
                break;
        }
    }
    
    private void sendToBlis()
    {
        switch(jlblSourceType.getText())
        {
            case "RS232":
                switch(jlblEquipment.getText())
                {
                    case "ABX MICROS 60":
                       // abx  = new MICROS60();
                       // abx.start();                       
                        break;
                }
            case "TCP/IP":
                switch(jlblEquipment.getText())
                {
                    case "Mindray BS-200E":
                       //obj = new MindrayBS200E();
                       //obj.start();                       
                        break;
                }
                break;
             case "MSACCESS":
                switch(jlblEquipment.getText())
                {
                    case "ABX Pentra 60C+":  
                        
                        log.AddToDisplay.Display("Manual Send to BLIS Sample Barcode:"+jtxtManualBarcode.getText(),log.DisplayMessageType.TITLE);
                        new MSACCESSABXPentra60CPlus().sendToBlis(jtxtManualBarcode.getText());
                        break;
                }
                break;
        }
    }
    private void stopAppropriateHandler()
    {
         switch(jlblSourceType.getText())
        {
            case "RS232":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "ABX MICROS 60":                        
                        abx.Stop();
                        break;
                    case "SELECTRA JUNIOR":                       
                        selobj.Stop();
                        break;
                     case "ABX PENTRA 80":
                        pentra80Obj.Stop();
                        break;
                      case "MINDRAY BC 3600":                        
                        minbc3600obj.Stop();
                        break;
                      case "BT3000 PLUS-CHAMELEON":
                          btRSobj.Stop();
                          break;
                      case "FLEXOR E":
                          flexObj.Stop();
                          break;
                    
                }
            case "TCP/IP":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "MINDRAY BS-120":
                    case "MINDRAY BS-130":
                    case "MINDRAY BS-180":                    
                    case "MINDRAY BS-190":
                    case "MINDRAY BS-200":
                    case "MINDRAY BS-220":
                    case "MINDRAY BS-200E":
                    case "MINDRAY BS-220E":
                    case "MINDRAY BS-330":
                    case "MINDRAY BS-350":                    
                    case "MINDRAY BS-330E":
                    case "MINDRAY BS-350E":          
                        obj.Stop();                     
                        break;
                    case "BT3000 PLUS-CHAMELEON":                      
                       btobj.Stop();
                        break;
                    case "SYSMEX XS-500I":                        
                        sysobj.Stop();
                        break;
                    case "COBAS AMPLIPREP":
                        cobasObj.Stop();
                        break;
                    case "GENEXPERT":
                        expobj.Stop();
                        break;
                    case "SYSMEX XT-2000I":
                        sys2000iObj.Stop();
                        break;
                }
                break;
            case "MSACCESS":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "ABX PENTRA 60C+":
                      msaccess_abx.Stop();  
                      break;
                }
                break;
            case "TEXT":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "BD FACSCALIBUR":                        
                        bdobj.Stop();
                        break;
                    
                }
                 break;
        }
    }
    private void startAppropriateHandler()
    {
        switch(jlblSourceType.getText())
        {
            case "RS232":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "ABX MICROS 60":
                        abx  = new MICROS60();
                        abx.start();                          
                        break;
                    case "SELECTRA JUNIOR":
                        selobj = new SelectraJunior();
                        selobj.start();
                        break;
                    case "ABX PENTRA 80":
                        pentra80Obj = new ABXPentra80();
                        pentra80Obj.start();
                        break;
                    case "MINDRAY BC 3600":
                        minbc3600obj = new MindrayBC3600();
                        minbc3600obj.start();
                        break;     
                    case "BT3000 PLUS-CHAMELEON":
                          btRSobj = new RS232.BT3000PlusChameleon();
                          btRSobj.start();
                          break;
                     case "FLEXOR E":
                          flexObj = new FlexorE();
                          flexObj.start();
                          break;
                }
            break;
            case "TCP/IP":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "MINDRAY BS-120":
                    case "MINDRAY BS-130":
                    case "MINDRAY BS-180":                    
                    case "MINDRAY BS-190":
                    case "MINDRAY BS-200":
                    case "MINDRAY BS-220":
                    case "MINDRAY BS-200E":
                    case "MINDRAY BS-220E":
                    case "MINDRAY BS-330":
                    case "MINDRAY BS-350":                    
                    case "MINDRAY BS-330E":
                    case "MINDRAY BS-350E":                  
                       obj = new MindrayBS200E(jlblEquipment.getText());
                       obj.start();                       
                        break;
                    case "BT3000 PLUS-CHAMELEON":
                       btobj = new TCPIP.BT3000PlusChameleon();
                       btobj.start();
                        break;
                    case "SYSMEX XS-500I":
                        sysobj = new SYSMEXXS500i();
                        sysobj.start();
                        break;
                     case "COBAS AMPLIPREP":
                        cobasObj= new CobasAmpliPrep();
                        cobasObj.start();
                        break;
                     case "GENEXPERT":
                        expobj = new GeneXpert();
                        expobj.start();
                        break;
                     case "SYSMEX XT-2000I":
                        sys2000iObj = new SYSMEXXT2000i();
                        sys2000iObj.start();
                        break;
                }
                break;
             case "MSACCESS":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "ABX PENTRA 60C+":
                     msaccess_abx = new MSACCESSABXPentra60CPlus();
                     msaccess_abx.start();
                        break;
                }
                break;
             case "TEXT":
                switch(jlblEquipment.getText().toUpperCase())
                {
                    case "BD FACSCALIBUR":
                    bdobj = new BDFACSCalibur();
                    bdobj.start();
                    break;                   
                }
                 break;
        }
    }
    private void getConfigurations()
    {
        String value = configuration.configuration.GetParameterValue(configuration.configuration.FEED_SOURCE);
        jlblSourceType.setText(value);         
        switch(value)
        {
            case "RS232": 
                 value = configuration.configuration.GetParameterValue(configuration.configuration.RS232_CONFIGURATIONS);
                 String[] RSvalues = value.split(",");
                 jtxtConfigs.setText(value.replaceAll(",", "\n"));
                setParams(RSvalues);
                 
                break;
            case "TCP/IP":
                 value = configuration.configuration.GetParameterValue(configuration.configuration.TCP_IP_CONFIGURATIONS);
                 String[] TCPvalues = value.split(",");
                 jtxtConfigs.setText(value.replaceAll(",", "\n"));
                  setParams(TCPvalues);
                break;
            case "MSACCESS":
                value = configuration.configuration.GetParameterValue(configuration.configuration.MSACCESS_CONFIGURATIONS);
                 String[] MSAccessValues = value.split(",");
                 jtxtConfigs.setText(value.replaceAll(",", "\n"));
                 setParams(MSAccessValues);
                break;
            case "TEXT":
                 value = configuration.configuration.GetParameterValue(configuration.configuration.TEXT);
                 String[] TEXTValues = value.split(",");
                 jtxtConfigs.setText(value.replaceAll(",", "\n"));
                 setParams(TEXTValues);
                break;
                
        }
        value = configuration.configuration.GetParameterValue(configuration.configuration.BLIS_CONFIGURATIONS);
        String[] blisParams = value.split(",");
        setParams(blisParams);
        
         equipment = configuration.configuration.GetParameterValue(configuration.configuration.EQUIPMENT);
         jlblEquipment.setText(equipment);
         trayIcon.setToolTip(trayIcon.getToolTip()+" ("+equipment +" handler)");
          
         
          value = configuration.configuration.GetParameterValue(configuration.configuration.MISCELLANEOUS);
          String[] misc = value.split(",");
          setParams(misc);
        
         
   }
    private void setParams(String[] values)
    {
       for(int i=0;i<values.length;i++)
       {
         String[] data = values[i].split("=");
         data[0]=data[0].trim();
         data[1]= data[1].trim();
         switch(data[0])
         {
             case "COMPORT":
                RS232Settings.COMPORT = data[1];
                 break;
             case "BAUD_RATE":
                 RS232Settings.BAUD = Integer.parseInt(data[1]);                 
                 break;
             case "PARITY":
                 if(data[1].equalsIgnoreCase("none"))
                    RS232Settings.PARITY = 0;
                 else if(data[1].equalsIgnoreCase("odd"))
                    RS232Settings.PARITY = 1;
                 else
                     RS232Settings.PARITY = 2;
                 break;
             case "STOP_BITS":
                 RS232Settings.STOPBIT = Integer.parseInt(data[1]);
                 break;
             case "DATA_BITS":
                 RS232Settings.DATABIT_LENGTH = Integer.parseInt(data[1]);
                 break;
             case "APPEND_NEWLINE":
                 RS232Settings.APPEND_NEWLINE = data[1].equalsIgnoreCase("yes");
                 break;
             case "APPEND_CARRIAGE_RETURN":
                 RS232Settings.APPEND_CARRIAGE_RETURN = data[1].equalsIgnoreCase("yes");
                 break;
             case "PORT":                
                 tcpsettings.PORT =Integer.parseInt(data[1]);
                 break;
             case "EQUIPMENT_IP":
                 tcpsettings.EQUIPMENT_IP = data[1];
                 break;
             case "BLIS_URL":
                 blis_URL = data[1]; 
                 jlblblisURL.setText(blis_URL);
                 settings.BLIS_URL = data[1];
                 break;
             case "BLIS_USERNAME":
                 blis_username = data[1];    
         try {
             settings.BLIS_USERNAME = URLEncoder.encode(data[1],"UTF-8");
         } catch (UnsupportedEncodingException ex) {
             Logger.getLogger(MainForm.class.getName()).log(Level.SEVERE, null, ex);
         }
                 break;
             case "BLIS_PASSWORD":
                 blis_password = data[1];  
         try {
             settings.BLIS_PASSWORD = URLEncoder.encode(data[1],"UTF-8");
         } catch (UnsupportedEncodingException ex) {
             Logger.getLogger(MainForm.class.getName()).log(Level.SEVERE, null, ex);
         }
                 break;
             case "ENABLE_LOG":
                 settings.ENABLE_LOG = data[1].equalsIgnoreCase("yes");
                 break;
             case "MSACCESS":
                 MSACCESS.Settings.DATASOURCE = data[1];
                 break;
             case "DAYS":
                 MSACCESS.Settings.DAYS = Integer.parseInt(data[1]);
                 break;
             case "DATASOURCE":
                  MSACCESS.Settings.DATASOURCE = data[1];
                 break;
             case "WRITE_TO_FILE":
                 settings.WRITE_TO_FILE = data[1].equalsIgnoreCase("yes");
                 break;
             case "POOL_DAY":
                 settings.POOL_DAY = Integer.parseInt(data[1]);
                 break;
             case "POOL_INTERVAL":
                 settings.POOL_INTERVAL = Integer.parseInt(data[1]);
                 break;
             case "ENABLE_AUTO_POOL":
                 settings.ENABLE_AUTO_POOL = data[1].equalsIgnoreCase("yes");
                 break;
             case "MODE":
                 settings.SERVER_MODE = data[1].equalsIgnoreCase("server");
                 tcpsettings.SERVER_MODE = data[1].equalsIgnoreCase("server");
                 break;
             case "CLIENT_RECONNECT":
                 tcpsettings.CLIENT_RECONNECT=data[1].equalsIgnoreCase("yes");
                 break;
             case "BASE_DIRECTORY":
                 TEXT.settings.BASE_DIRECTORY = data[1];
                 break;
             case "USE_SUB_DIRECTORIES":
                 TEXT.settings.USE_SUB_DIRECTORIES = data[1].equalsIgnoreCase("yes");
             case "SUB_DIRECTORY_FORMAT":
                 TEXT.settings.SUB_DIRECTORY_FORMAT = data[1];
                 break;
             case "FILE_NAME_FORMAT":
                 TEXT.settings.FILE_NAME_FORMAT = data[1];
                 break;
             case "FILE_EXTENSION":
                 TEXT.settings.FILE_EXTENSION = data[1];
                 break;
             case "FILE_SEPERATOR":
                 TEXT.settings.FILE_SEPERATOR = data[1];
                 TEXT.settings.setChar(data[1]);
                 break;
             case "AUTO_SPECIMEN_ID":
                 settings.AUTO_SPECIMEN_ID = data[1].equalsIgnoreCase("yes");
                 break;
                         
                 
                
                      
         }
       }
        
    }
    
    private void setManualActivity()
    {
        toggleManualActivity(false);
        switch(jlblSourceType.getText())
        {
            case "RS232":
                switch(jlblEquipment.getText())
                {
                    case "ABX Pentra 80":
                        toggleManualActivity(true);
                        jbtnSend.setEnabled(false);
                        break;
                    
                }
            break;
            case "TCP/IP":
                switch(jlblEquipment.getText())
                {
                    case "BT3000 Plus-Chameleon":       
                        toggleManualActivity(true);
                        jbtnSend.setEnabled(false);
                        break;
                    case "Cobas AmpliPrep":
                         toggleManualActivity(true);
                        jbtnSend.setEnabled(false);
                        break;
                }
                break;
             case "MSACCESS":
                switch(jlblEquipment.getText())
                {
                    case "ABX Pentra 60C+":
                        toggleManualActivity(true);
                        break;
                }
                break;
        }
    }
    
    private void toggleManualActivity(boolean flag)
    {
         //jpnlManualActivity.setEnabled(flag);
         //jLabel4.setEnabled(flag);
         jtxtManualBarcode.setEnabled(flag);
         jbtnDownload.setEnabled(flag);
         jbtnSend.setEnabled(flag);
    }
    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(MainForm.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(MainForm.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(MainForm.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(MainForm.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new MainForm().setVisible(true);
            }
        });
    }
    
    
    class ResetMan extends Thread
    {
        @Override
        public void run()
        {
            if(tcpsettings.CLIENT_RECONNECT)
            {
                while(true)
                {
                    if(set == RESET.NOW)
                        reset();
                    
                    try {
                        Thread.sleep(100);
                    } catch (InterruptedException ex) {
                        Logger.getLogger(MainForm.class.getName()).log(Level.SEVERE, null, ex);
                    }
                    
                }
            }
        }
        private void reset()
        {
            stopAppropriateHandler();
            startAppropriateHandler();
            synchronized(set)
            {
                set = RESET.WAIT;
            }
        }
    }
   

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JPanel jPanel1;
    private javax.swing.JPanel jPanel3;
    private javax.swing.JScrollPane jScrollPane2;
    private javax.swing.JScrollPane jScrollPane3;
    private javax.swing.JSplitPane jSplitPane1;
    private javax.swing.JSplitPane jSplitPane2;
    private javax.swing.JButton jbtnDownload;
    private javax.swing.JButton jbtnSend;
    private javax.swing.JButton jbtnStart;
    private javax.swing.JLabel jlblEquipment;
    private javax.swing.JLabel jlblSourceType;
    private javax.swing.JLabel jlblblisURL;
    private javax.swing.JPanel jpnlManualActivity;
    private javax.swing.JTextArea jtxtConfigs;
    private javax.swing.JTextField jtxtManualBarcode;
    public static javax.swing.JTextPane jtxtPaneDisplay;
    // End of variables declaration//GEN-END:variables
}
