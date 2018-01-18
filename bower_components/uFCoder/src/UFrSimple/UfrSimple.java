/**
 * ******************************************************************************
 *
 * Program : uFr Simple File : uFRSimple.java (main class) Description : Functions to work with the
 * keys card and reader key Author : VladanS Manufacturer : D-Logic Development enviroment :
 * NetBeans 7.2 Java Platform : JDK 1.7 Revisions	: Version : 1.6
 *
 *******************************************************************************
 */
package UFrSimple;

import static UFrSimple.UfrCoder.GetLibFullPath;
import UFrSimple.UfrCoder.uFrFunctions;
import com.sun.jna.Native;
import com.sun.jna.Platform;
import com.sun.jna.ptr.ByteByReference;
import com.sun.jna.ptr.IntByReference;
import com.sun.jna.ptr.ShortByReference;
import java.awt.Color;
import java.awt.event.FocusEvent;
import java.awt.event.FocusListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.util.concurrent.*;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.regex.Pattern;
import javax.swing.JCheckBox;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class UfrSimple extends javax.swing.JApplet implements KeyListener, FocusListener {

    static final int DL_OK = 0,
            RES_SOUND_OK = 0,//4
            RES_LIGHT_OK = 4,
            ERR_LIGHT = 2,
            ERR_SOUND = 0,//2
            BLOCK_DATA_LEN = 15,
            LINEAR_MAX_BYTES = 752,
            MAX_KEY_INDEX = 6,
            thread_sleep = 300;
    static final byte AUTH1A = 96, AUTH1B = 97;
    static final String ANY_DATA = "You must enter any data !",
            APPROPRIATE_FORMAT = "Enter a number between 0 and 255 for decimal or 0 to FF for hexadecimal";

    static final String NEW_CARD_KEY_A = "txtNewCardKeyA";
    static final String NEW_CARD_KEY_B = "txtNewCardKeyB";
    static final String NEW_READER_KEY = "txtNewReaderKey";

    uFrFunctions UFrInstance;

    private boolean bCONN = false,
            bReaderStop = false,
            bThreadStart = false,
            bFunctionOn = false;
    private byte bKeyIndex = 0;
    private int iResult = 0;
    private IntByReference iReaderType = new IntByReference();
    private IntByReference iReaderSerial = new IntByReference();
    private ByteByReference bCardType = new ByteByReference();
    private IntByReference iCardSerial = new IntByReference();
    ByteByReference bCardUIDSize = new ByteByReference();
    byte[] baCardUID = new byte[9];
    JTextField TF;
    ExecutorService exec = Executors.newCachedThreadPool();

    private void ReaderOn() {
        bReaderStop = false;
    }

    private void ReaderOff() {
        bReaderStop = true;
    }

    byte AuthMode() {
        return rbtnAUTH1A.isSelected() ? AUTH1A : AUTH1B;
    }

    @Override
    public void keyTyped(KeyEvent e) {
        boolean bPatternCheck;
        JTextField TB = (JTextField) e.getSource();
        if ((chkNewCardKeys.isSelected() && TB.getName() == NEW_CARD_KEY_A) || (chkNewCardKeys.isSelected() && TB.getName() == NEW_CARD_KEY_B)
                || chkNewReaderKey.isSelected() && TB.getName() == NEW_READER_KEY) {
            if (TB.getText().length() > 1) {
                e.consume();
            }
            bPatternCheck = Pattern.matches("[a-fA-F_0-9]", String.valueOf(e.getKeyChar()));
            if (!bPatternCheck) {
                e.consume();
            }
        } else {
            if (TB.getText().length() > 2) {
                e.consume();
            }
            bPatternCheck = Pattern.matches("[0-9]", String.valueOf(e.getKeyChar()));
            if (!bPatternCheck) {
                e.consume();
            }
        }
    }

    @Override
    public void keyPressed(KeyEvent e) {
    }

    @Override
    public void keyReleased(KeyEvent e) {
    }

    @Override
    public void focusGained(FocusEvent e) {
    }

    @Override
    public void focusLost(FocusEvent e) {
        try {
            JTextField TB = (JTextField) e.getSource();
            if (Short.parseShort(TB.getText(), 10) > 255) {
                JOptionPane.showMessageDialog(rootPane, APPROPRIATE_FORMAT, "Error", JOptionPane.ERROR_MESSAGE);
                TB.requestFocus();
                TB.selectAll();
            }
        } catch (NumberFormatException NFE) {

        }

    }

    private void CreateKey(int iKeyX, int iKeyY, int iKeyHeight, int iKeyWidth, String sKeyName, JPanel pnlContainer) {

        for (int br = 0; br < 6; br++) {
            TF = new JTextField();
            TF.setBounds(iKeyX + (iKeyWidth * br + 2), iKeyY, 30, 21);
            TF.setBorder(javax.swing.BorderFactory.createLineBorder(Color.BLACK));
            TF.setHorizontalAlignment(javax.swing.JTextField.CENTER);
            TF.setFont(new java.awt.Font("Verdana", 1, 11));
            TF.setName(sKeyName);
            TF.addKeyListener(this);
            TF.addFocusListener(this);
            TF.setText("");
            TF.setEditable(true);
            TF.setVisible(true);
            pnlContainer.add(TF);

        }
        pnlContainer.repaint();
    }

    class MainThread implements Runnable {

        @Override
        public void run() {
            try {
                while (true) {
                    if (!bReaderStop) {
                        MainThread();
                    }
                    TimeUnit.MILLISECONDS.sleep(thread_sleep);
                }
            } catch (Exception InEx) {
                Logger.getLogger(UfrSimple.class.getName()).log(Level.SEVERE, null, InEx);
            }
        }
    }

    private void ConvertToHex(JCheckBox CheckBox, JPanel pnlContainer, String sKeyName) {

        for (byte bBr = 0; bBr < pnlContainer.getComponentCount(); bBr++) {
            if (pnlContainer.getComponent(bBr).getName() == sKeyName && ((JTextField) (pnlContainer.getComponent(bBr))).getText().isEmpty()) {
                continue;
            } else {
                if (pnlContainer.getComponent(bBr).getName() == sKeyName) {
                    ((JTextField) (pnlContainer.getComponent(bBr))).setText(CheckBox.isSelected()
                            ? Integer.toHexString(Short.parseShort(((JTextField) (pnlContainer.getComponent(bBr))).getText()))
                            : Integer.toString(Short.parseShort(((JTextField) (pnlContainer.getComponent(bBr))).getText(), 16))
                    );
                }
            }
        }
    }

    private byte[] DecHexConversion(JCheckBox CheckBox, JPanel pnlKEYs, String sKeyName) {
        byte bCount = 0;
        byte[] baKey = new byte[MAX_KEY_INDEX];

        for (int br = 0; br < pnlKEYs.getComponentCount(); br++) {

            if (pnlKEYs.getComponent(br).getName() == sKeyName) {
                baKey[bCount] = CheckBox.isSelected() ? (byte) Short.parseShort(((JTextField) (pnlKEYs.getComponent(br))).getText(), 16)
                        : (byte) Short.parseShort(((JTextField) (pnlKEYs.getComponent(br))).getText());
                bCount++;
            }
        }

        return baKey;
    }

    private void MainThread() {
        bThreadStart = true;
        String sBuffer = "";
        if (!bCONN) {
            iResult = UFrInstance.ReaderOpen();
            if (iResult == DL_OK) {
                bCONN = true;
                txtConected.setText("CONNECTED");
            } else {
                txtConected.setText("NOT CONNECTED");
                txtReaderType.setText(null);
                txtReaderSerial.setText(null);
                txtCardType.setText(null);
                txtCardSerial.setText(null);
            }
            new Functions().ErrorCode(iResult, txtReaderCodeError, txtReaderErrorExplain);
        }
        if (bCONN) {
            iResult = UFrInstance.GetReaderType(iReaderType);
            if (iResult == DL_OK) {
                txtReaderType.setText("0x" + Integer.toHexString(iReaderType.getValue()).toUpperCase());
                iResult = UFrInstance.GetReaderSerialNumber(iReaderSerial);
                if (iResult == DL_OK) {
                    txtReaderSerial.setText("0x" + Integer.toHexString(iReaderSerial.getValue()).toUpperCase());

                    iResult = UFrInstance.GetCardIdEx(bCardType, baCardUID, bCardUIDSize);
                    if (iResult == DL_OK) {
                        
                         sBuffer = "";

                        for (byte bBr = 0; bBr < bCardUIDSize.getValue(); bBr++) {
                            sBuffer += Integer.toHexString((((char) baCardUID[bBr] & 0xFF))).toUpperCase();
                        }
                        
                        System.out.println(String.valueOf(sBuffer));
                        txtCardType.setText("0x" + Integer.toHexString(bCardType.getValue()).toUpperCase());
                        txtCardSerial.setText("0x" + sBuffer);

                    } else {
                        txtCardType.setText(null);
                        txtCardSerial.setText(null);
                    }
                    new Functions().ErrorCode(iResult, txtCardCode, txtCardExplainError);
                }
            } else {
                bCONN = false;
                UFrInstance.ReaderClose();
            }

        }
        bThreadStart = false;
    }

    @Override
    public void init() {
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Windows".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(UfrSimple.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(UfrSimple.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(UfrSimple.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(UfrSimple.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        try {
            java.awt.EventQueue.invokeAndWait(new Runnable() {

                @Override
                public void run() {
                    initComponents();

                }
            });
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    @Override
    public void start() {

        CreateKey(3, 3, 31, 29, NEW_CARD_KEY_A, pnlNewCardKeys);
        CreateKey(3, 35, 31, 29, NEW_CARD_KEY_B, pnlNewCardKeys);
        CreateKey(3, 10, 31, 29, NEW_READER_KEY, pnlNewReaderKey);
        bKeyIndex = Byte.parseByte(lblKeyIndexZero.getText(), 10);
        try {
            UFrInstance = (uFrFunctions) Native.loadLibrary(GetLibFullPath(true), uFrFunctions.class);
        } catch (UnsatisfiedLinkError e) {
            JOptionPane.showMessageDialog(null, "Unable to load library for path : " + GetLibFullPath(true));
        }

        exec.execute(new MainThread());
    }

    @Override
    public void stop() {
        exec.shutdown();
    }

    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        rbtnAuthMode = new javax.swing.ButtonGroup();
        buttonGroup1 = new javax.swing.ButtonGroup();
        pnlContainer = new javax.swing.JPanel();
        lblReaderType = new javax.swing.JLabel();
        txtReaderType = new javax.swing.JTextField();
        lblReaderSerial = new javax.swing.JLabel();
        txtReaderSerial = new javax.swing.JTextField();
        lblCardType = new javax.swing.JLabel();
        txtCardType = new javax.swing.JTextField();
        lblCardSerial = new javax.swing.JLabel();
        txtCardSerial = new javax.swing.JTextField();
        pnlSep1 = new javax.swing.JPanel();
        lblLightMode = new javax.swing.JLabel();
        cboLightMode = new javax.swing.JComboBox();
        lblSoundMode = new javax.swing.JLabel();
        cboSoundMode = new javax.swing.JComboBox();
        btnReaderUISignal = new javax.swing.JButton();
        stbReader = new javax.swing.JPanel();
        txtConected = new javax.swing.JTextField();
        txtReaderCodeError = new javax.swing.JTextField();
        txtReaderErrorExplain = new javax.swing.JTextField();
        stbCard = new javax.swing.JPanel();
        txtCardText = new javax.swing.JTextField();
        txtCardCode = new javax.swing.JTextField();
        txtCardExplainError = new javax.swing.JTextField();
        pnlFormat = new javax.swing.JPanel();
        pnlAuth1AB = new javax.swing.JPanel();
        rbtnAUTH1B = new javax.swing.JRadioButton();
        rbtnAUTH1A = new javax.swing.JRadioButton();
        pgNewCardReaderKeys = new javax.swing.JTabbedPane();
        tabNewCardKeys = new javax.swing.JPanel();
        lblKeyA = new javax.swing.JLabel();
        lblKeyB = new javax.swing.JLabel();
        chkNewCardKeys = new javax.swing.JCheckBox();
        pnlNewCardKeys = new javax.swing.JPanel();
        btnFormatCardKeys = new javax.swing.JButton();
        lblSectorsFormatted = new javax.swing.JLabel();
        txtSectorsFormatted = new javax.swing.JTextField();
        tabNewReaderKey = new javax.swing.JPanel();
        chkNewReaderKey = new javax.swing.JCheckBox();
        btnFormatReaderKey = new javax.swing.JButton();
        lblKeyIndexZero = new javax.swing.JLabel();
        lblKeyIndex = new javax.swing.JLabel();
        pnlNewReaderKey = new javax.swing.JPanel();
        pnlLinearReadWrite = new javax.swing.JPanel();
        tabLinearReadWrite = new javax.swing.JTabbedPane();
        tabLinearRead = new javax.swing.JPanel();
        lblReadData = new javax.swing.JLabel();
        lblLinearAddress = new javax.swing.JLabel();
        txtLinearAddress = new javax.swing.JTextField();
        lblDataLength = new javax.swing.JLabel();
        txtDataLength = new javax.swing.JTextField();
        lblBytesRead = new javax.swing.JLabel();
        txtBytesRead = new javax.swing.JTextField();
        btnLinearRead = new javax.swing.JButton();
        jScrollPane3 = new javax.swing.JScrollPane();
        txtLinearRead = new javax.swing.JTextArea();
        tabLinearWrite = new javax.swing.JPanel();
        lblWriteData = new javax.swing.JLabel();
        jScrollPane2 = new javax.swing.JScrollPane();
        txtLinearWrite = new javax.swing.JTextArea();
        lblLinearAddressWrite = new javax.swing.JLabel();
        lblDataLengthWrite = new javax.swing.JLabel();
        txtLinearAddressWrite = new javax.swing.JTextField();
        txtDataLengthWrite = new javax.swing.JTextField();
        lblBytesWritten = new javax.swing.JLabel();
        txtBytesWritten = new javax.swing.JTextField();
        btnLinearWrite = new javax.swing.JButton();
        stbFunction = new javax.swing.JPanel();
        txtFunctionError = new javax.swing.JTextField();
        txtFunctionCodeError = new javax.swing.JTextField();
        txtFunctionCodeExplain = new javax.swing.JTextField();

        pnlContainer.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblReaderType.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblReaderType.setText("Reader Type");

        txtReaderType.setEditable(false);
        txtReaderType.setBackground(java.awt.Color.white);
        txtReaderType.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtReaderType.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtReaderType.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblReaderSerial.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblReaderSerial.setText("Reader Serial");

        txtReaderSerial.setEditable(false);
        txtReaderSerial.setBackground(java.awt.Color.white);
        txtReaderSerial.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtReaderSerial.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtReaderSerial.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblCardType.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblCardType.setText("Card Type");

        txtCardType.setEditable(false);
        txtCardType.setBackground(java.awt.Color.white);
        txtCardType.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtCardType.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtCardType.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblCardSerial.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblCardSerial.setText("Card Serial");

        txtCardSerial.setEditable(false);
        txtCardSerial.setBackground(java.awt.Color.white);
        txtCardSerial.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtCardSerial.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtCardSerial.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        pnlSep1.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.RAISED));

        javax.swing.GroupLayout pnlSep1Layout = new javax.swing.GroupLayout(pnlSep1);
        pnlSep1.setLayout(pnlSep1Layout);
        pnlSep1Layout.setHorizontalGroup(
            pnlSep1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 0, Short.MAX_VALUE)
        );
        pnlSep1Layout.setVerticalGroup(
            pnlSep1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 0, Short.MAX_VALUE)
        );

        lblLightMode.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblLightMode.setText("Light Mode");

        cboLightMode.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        cboLightMode.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "None", "Long Green", "LongRed", "Alternation", "Flash" }));
        cboLightMode.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        cboLightMode.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));

        lblSoundMode.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblSoundMode.setText("Sound Mode");

        cboSoundMode.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        cboSoundMode.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "None", "Short", "Long", "Double Short", "Tripple Short", "Tripplet Melody" }));
        cboSoundMode.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        cboSoundMode.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));

        btnReaderUISignal.setFont(new java.awt.Font("Verdana", 0, 12)); // NOI18N
        btnReaderUISignal.setText("READER UI SIGNAL");
        btnReaderUISignal.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        btnReaderUISignal.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));
        btnReaderUISignal.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnReaderUISignalActionPerformed(evt);
            }
        });

        stbReader.setBorder(javax.swing.BorderFactory.createEtchedBorder());

        txtConected.setEditable(false);
        txtConected.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtConected.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtConected.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        txtReaderCodeError.setEditable(false);
        txtReaderCodeError.setFont(new java.awt.Font("Verdana", 1, 12)); // NOI18N
        txtReaderCodeError.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtReaderCodeError.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        txtReaderErrorExplain.setEditable(false);
        txtReaderErrorExplain.setFont(new java.awt.Font("Verdana", 1, 12)); // NOI18N
        txtReaderErrorExplain.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtReaderErrorExplain.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        javax.swing.GroupLayout stbReaderLayout = new javax.swing.GroupLayout(stbReader);
        stbReader.setLayout(stbReaderLayout);
        stbReaderLayout.setHorizontalGroup(
            stbReaderLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, stbReaderLayout.createSequentialGroup()
                .addComponent(txtConected, javax.swing.GroupLayout.PREFERRED_SIZE, 148, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(txtReaderCodeError, javax.swing.GroupLayout.PREFERRED_SIZE, 107, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(txtReaderErrorExplain))
        );
        stbReaderLayout.setVerticalGroup(
            stbReaderLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(stbReaderLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                .addComponent(txtReaderCodeError, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addComponent(txtConected, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addComponent(txtReaderErrorExplain, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
        );

        stbCard.setBorder(javax.swing.BorderFactory.createEtchedBorder());

        txtCardText.setEditable(false);
        txtCardText.setBackground(new java.awt.Color(204, 204, 204));
        txtCardText.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtCardText.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtCardText.setText("CARD STATUS");
        txtCardText.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        txtCardCode.setEditable(false);
        txtCardCode.setBackground(new java.awt.Color(204, 204, 204));
        txtCardCode.setFont(new java.awt.Font("Verdana", 1, 12)); // NOI18N
        txtCardCode.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtCardCode.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        txtCardExplainError.setEditable(false);
        txtCardExplainError.setBackground(new java.awt.Color(204, 204, 204));
        txtCardExplainError.setFont(new java.awt.Font("Verdana", 1, 12)); // NOI18N
        txtCardExplainError.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtCardExplainError.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        javax.swing.GroupLayout stbCardLayout = new javax.swing.GroupLayout(stbCard);
        stbCard.setLayout(stbCardLayout);
        stbCardLayout.setHorizontalGroup(
            stbCardLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, stbCardLayout.createSequentialGroup()
                .addComponent(txtCardText, javax.swing.GroupLayout.PREFERRED_SIZE, 148, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(txtCardCode, javax.swing.GroupLayout.PREFERRED_SIZE, 107, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(txtCardExplainError))
        );
        stbCardLayout.setVerticalGroup(
            stbCardLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(stbCardLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                .addComponent(txtCardCode, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addComponent(txtCardText, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addComponent(txtCardExplainError, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
        );

        javax.swing.GroupLayout pnlContainerLayout = new javax.swing.GroupLayout(pnlContainer);
        pnlContainer.setLayout(pnlContainerLayout);
        pnlContainerLayout.setHorizontalGroup(
            pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(pnlSep1, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addComponent(stbReader, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addComponent(stbCard, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addGroup(pnlContainerLayout.createSequentialGroup()
                .addGap(159, 159, 159)
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(txtReaderType, javax.swing.GroupLayout.PREFERRED_SIZE, 102, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(txtReaderSerial, javax.swing.GroupLayout.PREFERRED_SIZE, 102, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(33, 33, 33)
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(lblCardType)
                    .addComponent(lblCardSerial))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(txtCardSerial)
                    .addComponent(txtCardType))
                .addContainerGap())
            .addGroup(pnlContainerLayout.createSequentialGroup()
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(pnlContainerLayout.createSequentialGroup()
                        .addGap(63, 63, 63)
                        .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(lblReaderSerial)
                            .addComponent(lblReaderType)))
                    .addGroup(pnlContainerLayout.createSequentialGroup()
                        .addGap(62, 62, 62)
                        .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(lblSoundMode)
                            .addComponent(lblLightMode))))
                .addGap(18, 18, 18)
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addComponent(cboLightMode, javax.swing.GroupLayout.PREFERRED_SIZE, 110, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(cboSoundMode, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addComponent(btnReaderUISignal, javax.swing.GroupLayout.PREFERRED_SIZE, 201, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(37, 37, 37))
        );

        pnlContainerLayout.linkSize(javax.swing.SwingConstants.HORIZONTAL, new java.awt.Component[] {cboLightMode, cboSoundMode});

        pnlContainerLayout.setVerticalGroup(
            pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(pnlContainerLayout.createSequentialGroup()
                .addContainerGap()
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addGroup(pnlContainerLayout.createSequentialGroup()
                        .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(txtReaderType, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                            .addComponent(lblCardType)
                            .addComponent(txtCardType, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(txtReaderSerial, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                            .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                                .addComponent(lblCardSerial)
                                .addComponent(txtCardSerial, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))))
                    .addGroup(pnlContainerLayout.createSequentialGroup()
                        .addComponent(lblReaderType)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(lblReaderSerial)
                        .addGap(4, 4, 4)))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(pnlSep1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(pnlContainerLayout.createSequentialGroup()
                        .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(lblLightMode)
                            .addComponent(cboLightMode, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addGroup(pnlContainerLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(lblSoundMode)
                            .addComponent(cboSoundMode, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)))
                    .addComponent(btnReaderUISignal, javax.swing.GroupLayout.PREFERRED_SIZE, 54, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addComponent(stbCard, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(stbReader, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(4, 4, 4))
        );

        pnlFormat.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        pnlAuth1AB.setBackground(new java.awt.Color(255, 255, 255));
        pnlAuth1AB.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        rbtnAUTH1B.setBackground(java.awt.Color.white);
        rbtnAuthMode.add(rbtnAUTH1B);
        rbtnAUTH1B.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        rbtnAUTH1B.setText("AUTH 1B");
        rbtnAUTH1B.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));

        rbtnAUTH1A.setBackground(java.awt.Color.white);
        rbtnAuthMode.add(rbtnAUTH1A);
        rbtnAUTH1A.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        rbtnAUTH1A.setSelected(true);
        rbtnAUTH1A.setText("AUTH 1A");
        rbtnAUTH1A.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));

        javax.swing.GroupLayout pnlAuth1ABLayout = new javax.swing.GroupLayout(pnlAuth1AB);
        pnlAuth1AB.setLayout(pnlAuth1ABLayout);
        pnlAuth1ABLayout.setHorizontalGroup(
            pnlAuth1ABLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, pnlAuth1ABLayout.createSequentialGroup()
                .addGap(98, 98, 98)
                .addComponent(rbtnAUTH1A)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addComponent(rbtnAUTH1B)
                .addGap(117, 117, 117))
        );
        pnlAuth1ABLayout.setVerticalGroup(
            pnlAuth1ABLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(pnlAuth1ABLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                .addComponent(rbtnAUTH1B)
                .addComponent(rbtnAUTH1A))
        );

        lblKeyA.setText("Key A");

        lblKeyB.setText("Key B");

        chkNewCardKeys.setText("Hex");
        chkNewCardKeys.addItemListener(new java.awt.event.ItemListener() {
            public void itemStateChanged(java.awt.event.ItemEvent evt) {
                chkNewCardKeysItemStateChanged(evt);
            }
        });

        javax.swing.GroupLayout pnlNewCardKeysLayout = new javax.swing.GroupLayout(pnlNewCardKeys);
        pnlNewCardKeys.setLayout(pnlNewCardKeysLayout);
        pnlNewCardKeysLayout.setHorizontalGroup(
            pnlNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 226, Short.MAX_VALUE)
        );
        pnlNewCardKeysLayout.setVerticalGroup(
            pnlNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 58, Short.MAX_VALUE)
        );

        btnFormatCardKeys.setText("FORMAT CARD KEYS");
        btnFormatCardKeys.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnFormatCardKeysActionPerformed(evt);
            }
        });

        lblSectorsFormatted.setText("Sectors Formatted");

        txtSectorsFormatted.setEditable(false);
        txtSectorsFormatted.setBackground(new java.awt.Color(153, 153, 153));
        txtSectorsFormatted.setFont(new java.awt.Font("Tahoma", 1, 12)); // NOI18N
        txtSectorsFormatted.setForeground(new java.awt.Color(255, 255, 255));
        txtSectorsFormatted.setHorizontalAlignment(javax.swing.JTextField.CENTER);

        javax.swing.GroupLayout tabNewCardKeysLayout = new javax.swing.GroupLayout(tabNewCardKeys);
        tabNewCardKeys.setLayout(tabNewCardKeysLayout);
        tabNewCardKeysLayout.setHorizontalGroup(
            tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(tabNewCardKeysLayout.createSequentialGroup()
                .addGap(28, 28, 28)
                .addGroup(tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(lblKeyB)
                    .addComponent(lblKeyA))
                .addGap(18, 18, 18)
                .addGroup(tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(pnlNewCardKeys, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(chkNewCardKeys))
                .addGap(18, 18, 18)
                .addGroup(tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(btnFormatCardKeys, javax.swing.GroupLayout.DEFAULT_SIZE, 196, Short.MAX_VALUE)
                    .addGroup(tabNewCardKeysLayout.createSequentialGroup()
                        .addComponent(lblSectorsFormatted)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                        .addComponent(txtSectorsFormatted, javax.swing.GroupLayout.PREFERRED_SIZE, 51, javax.swing.GroupLayout.PREFERRED_SIZE)))
                .addContainerGap())
        );
        tabNewCardKeysLayout.setVerticalGroup(
            tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(tabNewCardKeysLayout.createSequentialGroup()
                .addContainerGap()
                .addGroup(tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addGroup(tabNewCardKeysLayout.createSequentialGroup()
                        .addGroup(tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                            .addComponent(pnlNewCardKeys, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                            .addGroup(tabNewCardKeysLayout.createSequentialGroup()
                                .addComponent(lblKeyA)
                                .addGap(18, 18, 18)
                                .addComponent(lblKeyB)))
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(chkNewCardKeys))
                    .addGroup(tabNewCardKeysLayout.createSequentialGroup()
                        .addComponent(btnFormatCardKeys, javax.swing.GroupLayout.PREFERRED_SIZE, 46, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                        .addGroup(tabNewCardKeysLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(txtSectorsFormatted)
                            .addComponent(lblSectorsFormatted))))
                .addContainerGap())
        );

        pgNewCardReaderKeys.addTab("New Card Keys", tabNewCardKeys);

        chkNewReaderKey.setText("Hex");
        chkNewReaderKey.addItemListener(new java.awt.event.ItemListener() {
            public void itemStateChanged(java.awt.event.ItemEvent evt) {
                chkNewReaderKeyItemStateChanged(evt);
            }
        });

        btnFormatReaderKey.setText("FORMAT READER KEY");
        btnFormatReaderKey.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnFormatReaderKeyActionPerformed(evt);
            }
        });

        lblKeyIndexZero.setBackground(new java.awt.Color(255, 255, 255));
        lblKeyIndexZero.setFont(new java.awt.Font("Verdana", 1, 24)); // NOI18N
        lblKeyIndexZero.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        lblKeyIndexZero.setText("0");
        lblKeyIndexZero.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        lblKeyIndexZero.setOpaque(true);

        lblKeyIndex.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblKeyIndex.setText("Key Index");

        javax.swing.GroupLayout pnlNewReaderKeyLayout = new javax.swing.GroupLayout(pnlNewReaderKey);
        pnlNewReaderKey.setLayout(pnlNewReaderKeyLayout);
        pnlNewReaderKeyLayout.setHorizontalGroup(
            pnlNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 226, Short.MAX_VALUE)
        );
        pnlNewReaderKeyLayout.setVerticalGroup(
            pnlNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 46, Short.MAX_VALUE)
        );

        javax.swing.GroupLayout tabNewReaderKeyLayout = new javax.swing.GroupLayout(tabNewReaderKey);
        tabNewReaderKey.setLayout(tabNewReaderKeyLayout);
        tabNewReaderKeyLayout.setHorizontalGroup(
            tabNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(tabNewReaderKeyLayout.createSequentialGroup()
                .addGap(99, 99, 99)
                .addGroup(tabNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(tabNewReaderKeyLayout.createSequentialGroup()
                        .addComponent(pnlNewReaderKey, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 31, Short.MAX_VALUE)
                        .addComponent(btnFormatReaderKey, javax.swing.GroupLayout.PREFERRED_SIZE, 158, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(tabNewReaderKeyLayout.createSequentialGroup()
                        .addComponent(chkNewReaderKey)
                        .addGap(85, 85, 85)
                        .addComponent(lblKeyIndex)
                        .addGap(26, 26, 26)
                        .addComponent(lblKeyIndexZero, javax.swing.GroupLayout.PREFERRED_SIZE, 27, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addGap(0, 0, Short.MAX_VALUE)))
                .addContainerGap())
        );
        tabNewReaderKeyLayout.setVerticalGroup(
            tabNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(tabNewReaderKeyLayout.createSequentialGroup()
                .addContainerGap()
                .addGroup(tabNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(tabNewReaderKeyLayout.createSequentialGroup()
                        .addComponent(pnlNewReaderKey, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addGap(1, 1, 1)
                        .addGroup(tabNewReaderKeyLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(chkNewReaderKey)
                            .addComponent(lblKeyIndexZero, javax.swing.GroupLayout.PREFERRED_SIZE, 35, javax.swing.GroupLayout.PREFERRED_SIZE)
                            .addComponent(lblKeyIndex)))
                    .addComponent(btnFormatReaderKey, javax.swing.GroupLayout.PREFERRED_SIZE, 46, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addContainerGap())
        );

        pgNewCardReaderKeys.addTab("New Reader Key", tabNewReaderKey);

        javax.swing.GroupLayout pnlFormatLayout = new javax.swing.GroupLayout(pnlFormat);
        pnlFormat.setLayout(pnlFormatLayout);
        pnlFormatLayout.setHorizontalGroup(
            pnlFormatLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(pnlAuth1AB, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addGroup(pnlFormatLayout.createSequentialGroup()
                .addContainerGap()
                .addComponent(pgNewCardReaderKeys)
                .addContainerGap())
        );
        pnlFormatLayout.setVerticalGroup(
            pnlFormatLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, pnlFormatLayout.createSequentialGroup()
                .addComponent(pnlAuth1AB, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(pgNewCardReaderKeys, javax.swing.GroupLayout.PREFERRED_SIZE, 138, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap())
        );

        pgNewCardReaderKeys.getAccessibleContext().setAccessibleName("New Card Keys");

        pnlLinearReadWrite.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        tabLinearReadWrite.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N

        tabLinearRead.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblReadData.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblReadData.setText("Read Data");

        lblLinearAddress.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblLinearAddress.setText("Linear Address");

        txtLinearAddress.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        txtLinearAddress.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtLinearAddress.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblDataLength.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblDataLength.setText("Data Length");

        txtDataLength.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        txtDataLength.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtDataLength.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblBytesRead.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblBytesRead.setText("Bytes Read");

        txtBytesRead.setEditable(false);
        txtBytesRead.setBackground(java.awt.Color.lightGray);
        txtBytesRead.setFont(new java.awt.Font("Tahoma", 1, 13)); // NOI18N
        txtBytesRead.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtBytesRead.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        btnLinearRead.setFont(new java.awt.Font("Verdana", 1, 14)); // NOI18N
        btnLinearRead.setText("READ");
        btnLinearRead.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        btnLinearRead.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));
        btnLinearRead.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnLinearReadActionPerformed(evt);
            }
        });

        txtLinearRead.setColumns(20);
        txtLinearRead.setEditable(false);
        txtLinearRead.setFont(new java.awt.Font("Verdana", 0, 12)); // NOI18N
        txtLinearRead.setLineWrap(true);
        txtLinearRead.setRows(5);
        txtLinearRead.setWrapStyleWord(true);
        txtLinearRead.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        jScrollPane3.setViewportView(txtLinearRead);

        javax.swing.GroupLayout tabLinearReadLayout = new javax.swing.GroupLayout(tabLinearRead);
        tabLinearRead.setLayout(tabLinearReadLayout);
        tabLinearReadLayout.setHorizontalGroup(
            tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(tabLinearReadLayout.createSequentialGroup()
                .addGap(20, 20, 20)
                .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(tabLinearReadLayout.createSequentialGroup()
                        .addComponent(jScrollPane3, javax.swing.GroupLayout.PREFERRED_SIZE, 506, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addContainerGap())
                    .addGroup(tabLinearReadLayout.createSequentialGroup()
                        .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                            .addGroup(javax.swing.GroupLayout.Alignment.LEADING, tabLinearReadLayout.createSequentialGroup()
                                .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                    .addComponent(lblDataLength)
                                    .addComponent(lblLinearAddress))
                                .addGap(18, 18, 18)
                                .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                    .addComponent(txtLinearAddress, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)
                                    .addGroup(tabLinearReadLayout.createSequentialGroup()
                                        .addComponent(txtDataLength, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)
                                        .addGap(48, 48, 48)
                                        .addComponent(lblBytesRead)
                                        .addGap(18, 18, 18)
                                        .addComponent(txtBytesRead, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)))
                                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 58, Short.MAX_VALUE)
                                .addComponent(btnLinearRead, javax.swing.GroupLayout.PREFERRED_SIZE, 128, javax.swing.GroupLayout.PREFERRED_SIZE))
                            .addComponent(lblReadData, javax.swing.GroupLayout.Alignment.LEADING))
                        .addGap(22, 22, 22))))
        );
        tabLinearReadLayout.setVerticalGroup(
            tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(tabLinearReadLayout.createSequentialGroup()
                .addContainerGap()
                .addComponent(lblReadData)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jScrollPane3, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(tabLinearReadLayout.createSequentialGroup()
                        .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(lblLinearAddress)
                            .addComponent(txtLinearAddress, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(lblDataLength)
                            .addComponent(txtDataLength, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)))
                    .addGroup(tabLinearReadLayout.createSequentialGroup()
                        .addGap(16, 16, 16)
                        .addGroup(tabLinearReadLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                            .addComponent(lblBytesRead)
                            .addComponent(txtBytesRead, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)))
                    .addComponent(btnLinearRead, javax.swing.GroupLayout.DEFAULT_SIZE, 46, Short.MAX_VALUE))
                .addContainerGap())
        );

        tabLinearReadWrite.addTab("Linear Read", tabLinearRead);

        tabLinearWrite.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblWriteData.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblWriteData.setText("Write Data");

        txtLinearWrite.setColumns(20);
        txtLinearWrite.setFont(new java.awt.Font("Verdana", 0, 12)); // NOI18N
        txtLinearWrite.setLineWrap(true);
        txtLinearWrite.setRows(5);
        txtLinearWrite.setWrapStyleWord(true);
        txtLinearWrite.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        jScrollPane2.setViewportView(txtLinearWrite);

        lblLinearAddressWrite.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblLinearAddressWrite.setText("Linear Address");

        lblDataLengthWrite.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblDataLengthWrite.setText("Data Length");

        txtLinearAddressWrite.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        txtLinearAddressWrite.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtLinearAddressWrite.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        txtDataLengthWrite.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        txtDataLengthWrite.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtDataLengthWrite.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        lblBytesWritten.setFont(new java.awt.Font("Verdana", 0, 11)); // NOI18N
        lblBytesWritten.setText("Bytes Written");

        txtBytesWritten.setEditable(false);
        txtBytesWritten.setBackground(java.awt.Color.lightGray);
        txtBytesWritten.setFont(new java.awt.Font("Tahoma", 1, 13)); // NOI18N
        txtBytesWritten.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtBytesWritten.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));

        btnLinearWrite.setFont(new java.awt.Font("Verdana", 1, 14)); // NOI18N
        btnLinearWrite.setText("WRITE");
        btnLinearWrite.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        btnLinearWrite.setCursor(new java.awt.Cursor(java.awt.Cursor.HAND_CURSOR));
        btnLinearWrite.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnLinearWriteActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout tabLinearWriteLayout = new javax.swing.GroupLayout(tabLinearWrite);
        tabLinearWrite.setLayout(tabLinearWriteLayout);
        tabLinearWriteLayout.setHorizontalGroup(
            tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 542, Short.MAX_VALUE)
            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                .addGroup(tabLinearWriteLayout.createSequentialGroup()
                    .addGap(21, 21, 21)
                    .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                        .addGroup(tabLinearWriteLayout.createSequentialGroup()
                            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                .addComponent(lblDataLengthWrite)
                                .addComponent(lblLinearAddressWrite))
                            .addGap(18, 18, 18)
                            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                .addComponent(txtLinearAddressWrite, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)
                                .addGroup(tabLinearWriteLayout.createSequentialGroup()
                                    .addComponent(txtDataLengthWrite, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)
                                    .addGap(48, 48, 48)
                                    .addComponent(lblBytesWritten)
                                    .addGap(18, 18, 18)
                                    .addComponent(txtBytesWritten, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)))
                            .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(btnLinearWrite, javax.swing.GroupLayout.PREFERRED_SIZE, 128, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addGroup(tabLinearWriteLayout.createSequentialGroup()
                            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                .addComponent(jScrollPane2, javax.swing.GroupLayout.PREFERRED_SIZE, 506, javax.swing.GroupLayout.PREFERRED_SIZE)
                                .addComponent(lblWriteData))
                            .addGap(1, 1, 1)))
                    .addContainerGap(14, Short.MAX_VALUE)))
        );
        tabLinearWriteLayout.setVerticalGroup(
            tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 179, Short.MAX_VALUE)
            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                .addGroup(tabLinearWriteLayout.createSequentialGroup()
                    .addGap(11, 11, 11)
                    .addComponent(lblWriteData)
                    .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                    .addComponent(jScrollPane2, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                        .addGroup(tabLinearWriteLayout.createSequentialGroup()
                            .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                                .addComponent(lblLinearAddressWrite)
                                .addComponent(txtLinearAddressWrite, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                            .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                                .addComponent(lblDataLengthWrite)
                                .addComponent(txtDataLengthWrite, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)))
                        .addGroup(tabLinearWriteLayout.createSequentialGroup()
                            .addGap(16, 16, 16)
                            .addGroup(tabLinearWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                                .addComponent(lblBytesWritten)
                                .addComponent(txtBytesWritten, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)))
                        .addGroup(tabLinearWriteLayout.createSequentialGroup()
                            .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                            .addComponent(btnLinearWrite, javax.swing.GroupLayout.DEFAULT_SIZE, 46, Short.MAX_VALUE)))
                    .addGap(11, 11, 11)))
        );

        tabLinearReadWrite.addTab("Linear Write", tabLinearWrite);

        javax.swing.GroupLayout pnlLinearReadWriteLayout = new javax.swing.GroupLayout(pnlLinearReadWrite);
        pnlLinearReadWrite.setLayout(pnlLinearReadWriteLayout);
        pnlLinearReadWriteLayout.setHorizontalGroup(
            pnlLinearReadWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(tabLinearReadWrite, javax.swing.GroupLayout.PREFERRED_SIZE, 0, Short.MAX_VALUE)
        );
        pnlLinearReadWriteLayout.setVerticalGroup(
            pnlLinearReadWriteLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, pnlLinearReadWriteLayout.createSequentialGroup()
                .addComponent(tabLinearReadWrite, javax.swing.GroupLayout.PREFERRED_SIZE, 210, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap())
        );

        stbFunction.setBorder(javax.swing.BorderFactory.createEtchedBorder());

        txtFunctionError.setEditable(false);
        txtFunctionError.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtFunctionError.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtFunctionError.setText("Function Error");
        txtFunctionError.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        txtFunctionCodeError.setEditable(false);
        txtFunctionCodeError.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtFunctionCodeError.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtFunctionCodeError.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        txtFunctionCodeExplain.setEditable(false);
        txtFunctionCodeExplain.setFont(new java.awt.Font("Verdana", 1, 11)); // NOI18N
        txtFunctionCodeExplain.setHorizontalAlignment(javax.swing.JTextField.CENTER);
        txtFunctionCodeExplain.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));

        javax.swing.GroupLayout stbFunctionLayout = new javax.swing.GroupLayout(stbFunction);
        stbFunction.setLayout(stbFunctionLayout);
        stbFunctionLayout.setHorizontalGroup(
            stbFunctionLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(stbFunctionLayout.createSequentialGroup()
                .addComponent(txtFunctionError, javax.swing.GroupLayout.PREFERRED_SIZE, 138, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(txtFunctionCodeError, javax.swing.GroupLayout.PREFERRED_SIZE, 107, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(txtFunctionCodeExplain))
        );
        stbFunctionLayout.setVerticalGroup(
            stbFunctionLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(stbFunctionLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                .addComponent(txtFunctionCodeError, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addComponent(txtFunctionError, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addComponent(txtFunctionCodeExplain, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
        );

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(pnlContainer, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addComponent(pnlFormat, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addComponent(pnlLinearReadWrite, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addComponent(stbFunction, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addComponent(pnlContainer, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(pnlFormat, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(pnlLinearReadWrite, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addComponent(stbFunction, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
        );
    }// </editor-fold>//GEN-END:initComponents


    private void btnReaderUISignalActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnReaderUISignalActionPerformed
        if (bFunctionOn) {
            return;
        }
        bFunctionOn = true;
        ReaderOff();
        if (bThreadStart) {
            bFunctionOn = false;
            return;
        }
        UFrInstance.ReaderUISignal(cboLightMode.getSelectedIndex(), cboSoundMode.getSelectedIndex());
        ReaderOn();
        bFunctionOn = false;
    }//GEN-LAST:event_btnReaderUISignalActionPerformed

    private void btnLinearReadActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnLinearReadActionPerformed

        if (bFunctionOn) {
            return;
        }
        bFunctionOn = true;
        ReaderOff();
        if (bThreadStart) {
            bFunctionOn = false;
            return;
        }
        try {
            int iLinearAddress = 0;
            int iDataLength = 0;
            ShortByReference shBytesRead = new ShortByReference();
            byte[] baReadData = new byte[LINEAR_MAX_BYTES];

            if (txtLinearAddress.getText().trim().isEmpty()) {
                JOptionPane.showMessageDialog(rootPane, "You must enter LINEAR ADDRESS !", "Warning !",
                        JOptionPane.WARNING_MESSAGE);
                txtLinearAddress.requestFocus();
                return;
            }
            if (txtDataLength.getText().trim().isEmpty()) {
                JOptionPane.showMessageDialog(rootPane, "You must enter DATA LENGTH !", "Warning !",
                        JOptionPane.WARNING_MESSAGE);
                txtDataLength.requestFocus();
                return;
            }
            txtLinearRead.setText(null);
            txtBytesRead.setText(null);
            iLinearAddress = Integer.parseInt(txtLinearAddress.getText().trim());
            iDataLength = Integer.parseInt(txtDataLength.getText().trim());

            iResult = UFrInstance.LinearRead(baReadData, iLinearAddress, iDataLength, shBytesRead, AuthMode(), bKeyIndex);
            if (iResult == DL_OK) {
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
                txtLinearRead.setText(new String(baReadData, 0, iDataLength));
                txtBytesRead.setText(Short.toString(shBytesRead.getValue()));
                UFrInstance.ReaderUISignal(RES_LIGHT_OK, RES_SOUND_OK);
            } else {
                UFrInstance.ReaderUISignal(ERR_LIGHT, ERR_SOUND);
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
            }

        } catch (NumberFormatException NfEx) {
            JOptionPane.showMessageDialog(rootPane, APPROPRIATE_FORMAT, "Error !", JOptionPane.ERROR_MESSAGE);
        } finally {
            ReaderOn();
            bFunctionOn = false;
        }
    }//GEN-LAST:event_btnLinearReadActionPerformed

    private void btnLinearWriteActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnLinearWriteActionPerformed
        if (bFunctionOn) {
            return;
        }
        bFunctionOn = true;
        ReaderOff();
        if (bThreadStart) {
            bFunctionOn = false;
            return;
        }

        int iLinearAddress = 0;
        int iDataLength = 0;
        ShortByReference shBytesWritten = new ShortByReference();
        byte[] baWriteData = new byte[LINEAR_MAX_BYTES];

        try {
            if (txtLinearWrite.getText().trim().isEmpty()) {
                JOptionPane.showMessageDialog(rootPane, ANY_DATA, "Warning !",
                        JOptionPane.WARNING_MESSAGE);
                txtLinearWrite.requestFocus();
                return;
            }
            if (txtLinearAddressWrite.getText().trim().isEmpty()) {
                JOptionPane.showMessageDialog(rootPane, "You must enter LINEAR ADDRESS !", "Warning !",
                        JOptionPane.WARNING_MESSAGE);
                txtLinearAddressWrite.requestFocus();
                return;
            }
            if (txtDataLengthWrite.getText().trim().isEmpty()) {
                JOptionPane.showMessageDialog(rootPane, "You must enter DATA LENGTH !", "Warning !",
                        JOptionPane.WARNING_MESSAGE);
                txtDataLengthWrite.requestFocus();
                return;
            }
            txtBytesWritten.setText(null);

            iLinearAddress = Integer.parseInt(txtLinearAddressWrite.getText().trim());
            iDataLength = Integer.parseInt(txtDataLengthWrite.getText().trim());
            baWriteData = txtLinearWrite.getText().getBytes();
            iResult = UFrInstance.LinearWrite(new Functions().WriteArray(baWriteData, iDataLength, LINEAR_MAX_BYTES), iLinearAddress, iDataLength,
                    shBytesWritten, AuthMode(), bKeyIndex);

            if (iResult == DL_OK) {
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
                txtBytesWritten.setText(Short.toString(shBytesWritten.getValue()));
                UFrInstance.ReaderUISignal(RES_LIGHT_OK, RES_SOUND_OK);
            } else {
                UFrInstance.ReaderUISignal(ERR_LIGHT, ERR_SOUND);
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
            }

        } catch (NumberFormatException NfEx) {
            JOptionPane.showMessageDialog(rootPane, APPROPRIATE_FORMAT, "Error !", JOptionPane.ERROR_MESSAGE);
        } finally {

            ReaderOn();
            bFunctionOn = false;
        }
    }//GEN-LAST:event_btnLinearWriteActionPerformed

    private void btnFormatCardKeysActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnFormatCardKeysActionPerformed
        if (bFunctionOn) {
            return;
        }
        bFunctionOn = true;
        ReaderOff();
        if (bThreadStart) {
            bFunctionOn = false;
            return;
        }

        byte[] baKeyA = new byte[MAX_KEY_INDEX];
        byte[] baKeyB = new byte[MAX_KEY_INDEX];

        byte bBlockAccessBits = 0;
        byte bSectorAccessBits = 1;
        byte bSectorTrailersByte9 = 45;
        ShortByReference shSectorsFormatted = new ShortByReference();

        try {
            baKeyA = DecHexConversion(chkNewCardKeys, pnlNewCardKeys, NEW_CARD_KEY_A);
            baKeyB = DecHexConversion(chkNewCardKeys, pnlNewCardKeys, NEW_CARD_KEY_B);
            iResult = UFrInstance.LinearFormatCard(baKeyA, bBlockAccessBits, bSectorAccessBits, bSectorTrailersByte9, baKeyB, shSectorsFormatted, AuthMode(), bKeyIndex);

            if (iResult == DL_OK) {
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
                txtSectorsFormatted.setText(Short.toString(shSectorsFormatted.getValue()));
                UFrInstance.ReaderUISignal(RES_LIGHT_OK, RES_SOUND_OK);
                JOptionPane.showMessageDialog(this, "Card keys are formatted successfully !", "Information", JOptionPane.INFORMATION_MESSAGE);
            } else {
                UFrInstance.ReaderUISignal(ERR_LIGHT, ERR_SOUND);
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
                txtSectorsFormatted.setText(Short.toString(shSectorsFormatted.getValue()));
                JOptionPane.showMessageDialog(this, "Card keys are not formatted successfully !", "Error ", JOptionPane.ERROR_MESSAGE);
            }

        } catch (NumberFormatException NfEx) {
            JOptionPane.showMessageDialog(rootPane, APPROPRIATE_FORMAT, "Error !", JOptionPane.ERROR_MESSAGE);
        } finally {

            ReaderOn();
            bFunctionOn = false;
        }
    }//GEN-LAST:event_btnFormatCardKeysActionPerformed

    private void btnFormatReaderKeyActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnFormatReaderKeyActionPerformed
        if (bFunctionOn) {
            return;
        }
        bFunctionOn = true;
        ReaderOff();
        if (bThreadStart) {
            bFunctionOn = false;
            return;
        }
        try {
            byte[] baReaderKey = new byte[MAX_KEY_INDEX];
            baReaderKey = DecHexConversion(chkNewReaderKey, pnlNewReaderKey, NEW_READER_KEY);
            iResult = UFrInstance.ReaderKeyWrite(baReaderKey, bKeyIndex);

            if (iResult == DL_OK) {
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
                UFrInstance.ReaderUISignal(RES_LIGHT_OK, RES_SOUND_OK);
                JOptionPane.showMessageDialog(this, "Reader key is formatted successfully !", "Information", JOptionPane.INFORMATION_MESSAGE);
            } else {
                UFrInstance.ReaderUISignal(ERR_LIGHT, ERR_SOUND);
                new Functions().ErrorCode(iResult, txtFunctionCodeError, txtFunctionCodeExplain);
                JOptionPane.showMessageDialog(this, "Reader key is not formatted successfully !", "Error ", JOptionPane.ERROR_MESSAGE);
            }

        } catch (NumberFormatException NfEx) {
            JOptionPane.showMessageDialog(rootPane, APPROPRIATE_FORMAT, "Error !", JOptionPane.ERROR_MESSAGE);
        } finally {

            ReaderOn();
            bFunctionOn = false;
        }
    }//GEN-LAST:event_btnFormatReaderKeyActionPerformed

    private void chkNewCardKeysItemStateChanged(java.awt.event.ItemEvent evt) {//GEN-FIRST:event_chkNewCardKeysItemStateChanged
        ConvertToHex(chkNewCardKeys, pnlNewCardKeys, NEW_CARD_KEY_A);
        ConvertToHex(chkNewCardKeys, pnlNewCardKeys, NEW_CARD_KEY_B);
    }//GEN-LAST:event_chkNewCardKeysItemStateChanged

    private void chkNewReaderKeyItemStateChanged(java.awt.event.ItemEvent evt) {//GEN-FIRST:event_chkNewReaderKeyItemStateChanged
        ConvertToHex(chkNewReaderKey, pnlNewReaderKey, NEW_READER_KEY);
    }//GEN-LAST:event_chkNewReaderKeyItemStateChanged

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton btnFormatCardKeys;
    private javax.swing.JButton btnFormatReaderKey;
    private javax.swing.JButton btnLinearRead;
    private javax.swing.JButton btnLinearWrite;
    private javax.swing.JButton btnReaderUISignal;
    private javax.swing.ButtonGroup buttonGroup1;
    private javax.swing.JComboBox cboLightMode;
    private javax.swing.JComboBox cboSoundMode;
    private javax.swing.JCheckBox chkNewCardKeys;
    private javax.swing.JCheckBox chkNewReaderKey;
    private javax.swing.JScrollPane jScrollPane2;
    private javax.swing.JScrollPane jScrollPane3;
    private javax.swing.JLabel lblBytesRead;
    private javax.swing.JLabel lblBytesWritten;
    private javax.swing.JLabel lblCardSerial;
    private javax.swing.JLabel lblCardType;
    private javax.swing.JLabel lblDataLength;
    private javax.swing.JLabel lblDataLengthWrite;
    private javax.swing.JLabel lblKeyA;
    private javax.swing.JLabel lblKeyB;
    private javax.swing.JLabel lblKeyIndex;
    private javax.swing.JLabel lblKeyIndexZero;
    private javax.swing.JLabel lblLightMode;
    private javax.swing.JLabel lblLinearAddress;
    private javax.swing.JLabel lblLinearAddressWrite;
    private javax.swing.JLabel lblReadData;
    private javax.swing.JLabel lblReaderSerial;
    private javax.swing.JLabel lblReaderType;
    private javax.swing.JLabel lblSectorsFormatted;
    private javax.swing.JLabel lblSoundMode;
    private javax.swing.JLabel lblWriteData;
    private javax.swing.JTabbedPane pgNewCardReaderKeys;
    private javax.swing.JPanel pnlAuth1AB;
    private javax.swing.JPanel pnlContainer;
    private javax.swing.JPanel pnlFormat;
    private javax.swing.JPanel pnlLinearReadWrite;
    private javax.swing.JPanel pnlNewCardKeys;
    private javax.swing.JPanel pnlNewReaderKey;
    private javax.swing.JPanel pnlSep1;
    private javax.swing.JRadioButton rbtnAUTH1A;
    private javax.swing.JRadioButton rbtnAUTH1B;
    private javax.swing.ButtonGroup rbtnAuthMode;
    private javax.swing.JPanel stbCard;
    private javax.swing.JPanel stbFunction;
    private javax.swing.JPanel stbReader;
    private javax.swing.JPanel tabLinearRead;
    private javax.swing.JTabbedPane tabLinearReadWrite;
    private javax.swing.JPanel tabLinearWrite;
    private javax.swing.JPanel tabNewCardKeys;
    private javax.swing.JPanel tabNewReaderKey;
    private javax.swing.JTextField txtBytesRead;
    private javax.swing.JTextField txtBytesWritten;
    private javax.swing.JTextField txtCardCode;
    private javax.swing.JTextField txtCardExplainError;
    private javax.swing.JTextField txtCardSerial;
    private javax.swing.JTextField txtCardText;
    private javax.swing.JTextField txtCardType;
    private javax.swing.JTextField txtConected;
    private javax.swing.JTextField txtDataLength;
    private javax.swing.JTextField txtDataLengthWrite;
    private javax.swing.JTextField txtFunctionCodeError;
    private javax.swing.JTextField txtFunctionCodeExplain;
    private javax.swing.JTextField txtFunctionError;
    private javax.swing.JTextField txtLinearAddress;
    private javax.swing.JTextField txtLinearAddressWrite;
    private javax.swing.JTextArea txtLinearRead;
    private javax.swing.JTextArea txtLinearWrite;
    private javax.swing.JTextField txtReaderCodeError;
    private javax.swing.JTextField txtReaderErrorExplain;
    private javax.swing.JTextField txtReaderSerial;
    private javax.swing.JTextField txtReaderType;
    private javax.swing.JTextField txtSectorsFormatted;
    // End of variables declaration//GEN-END:variables
}
