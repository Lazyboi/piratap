/****************************************************************************
  
   Program                :  uFr Simple
   File                   :  Functions.java 
   Description            :  Other functions
   Author                 :  VladanS
   Manufacturer           :  D-Logic
   Development enviroment :  NetBeans 7.2 
   Java Platform          :  JDK 1.7
   Revisions	          :  
   Version                :  1.6
   
*****************************************************************************/

package UFrSimple;

import javax.swing.JTextField;


public class Functions 
{
 
  String[]ERR_CODE =new String[180];

  public void ErrorCode(int result,JTextField error_code,JTextField error_example)
  {
            ERR_CODE[0] = "DL_OK ";
            ERR_CODE[1] = "COMMUNICATION_ERROR";
            ERR_CODE[2] = "CHKSUM_ERROR";
            ERR_CODE[3] = "READING_ERROR";
            ERR_CODE[4] = "WRITING_ERROR";
            ERR_CODE[5] = "BUFFER_OVERFLOW";
            ERR_CODE[6] = "MAX_ADDRESS_EXCEEDED";
            ERR_CODE[7] = "MAX_KEY_INDEX_EXCEEDED";
            ERR_CODE[8] = "NO_CARD";
            ERR_CODE[9] = "COMMAND_NOT_SUPPORTED";
            ERR_CODE[10] = " FORBIDEN_DIRECT_WRITE_IN_SECTOR_TRAILER";
            ERR_CODE[11] = " ADDRESSED_BLOCK_IS_NOT_SECTOR_TRAILER  ";
            ERR_CODE[12] = " WRONG_ADDRESS_MODE  ";
            ERR_CODE[13] = " WRONG_ACCESS_BITS_VALUES  ";
            ERR_CODE[14] = " AUTH_ERROR  ";
            ERR_CODE[15] = " PARAMETERS_ERROR  ";
            ERR_CODE[16] = " MAX_SIZE_EXCEEDED  ";

            ERR_CODE[80] = " COMMUNICATION_BREAK  ";
            ERR_CODE[81] = " NO_MEMORY_ERROR  ";
            ERR_CODE[82] = " CAN_NOT_OPEN_READER  ";
            ERR_CODE[83] = " READER_NOT_SUPPORTED  ";
            ERR_CODE[84] = " READER_OPENING_ERROR  ";
            ERR_CODE[85] = " READER_PORT_NOT_OPENED  ";
            ERR_CODE[86] = " CANT_CLOSE_READER_PORT  ";

            ERR_CODE[112] = " WRITE_VERIFICATION_ERROR  ";
            ERR_CODE[113] = " BUFFER_SIZE_EXCEEDED  ";
            ERR_CODE[114] = " VALUE_BLOCK_INVALID  ";
            ERR_CODE[115] = " VALUE_BLOCK_ADDR_INVALID  ";
            ERR_CODE[116] = " VALUE_BLOCK_MANIPULATION_ERROR  ";
            ERR_CODE[117] = " WRONG_UI_MODE ";
            ERR_CODE[118] = " KEYS_LOCKED ";
            ERR_CODE[119] = " KEYS_UNLOCKED ";
            ERR_CODE[120] = " WRONG_PASSWORD ";
            ERR_CODE[121] = " CAN_NOT_LOCK_DEVICE ";
            ERR_CODE[122] = " CAN_NOT_UNLOCK_DEVICE ";
            ERR_CODE[123] = " DEVICE_EEPROM_BUSY ";
            ERR_CODE[124] = " RTC_SET_ERROR ";

            ERR_CODE[160] = " FT_STATUS_ERROR_1 ";
            ERR_CODE[161] = " FT_STATUS_ERROR_2 ";
            ERR_CODE[162] = " FT_STATUS_ERROR_3 ";
            ERR_CODE[163] = " FT_STATUS_ERROR_4 ";
            ERR_CODE[164] = " FT_STATUS_ERROR_5 ";
            ERR_CODE[165] = " FT_STATUS_ERROR_6 ";
            ERR_CODE[166] = " FT_STATUS_ERROR_7 ";
            ERR_CODE[167] = " FT_STATUS_ERROR_8 "; 
                
            error_code.setText("0x"+Integer.toHexString(result));
            error_example.setText(ERR_CODE[result]);
  }
  
  public byte[] WriteArray(byte[] bGetBytesArray,int iDataLength,int iMaxBytes)
        {
            byte[] bCloneArray = new byte[iMaxBytes];
            System.arraycopy(bGetBytesArray,0, bCloneArray,0, bGetBytesArray.length);
            for (int br = bGetBytesArray.length; br < iDataLength; br++)
            {
                bCloneArray[br] = 32;
            }                                    
             return bCloneArray;
        }
}
