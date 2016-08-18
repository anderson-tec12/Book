<?php

/* TODO: Add code here */

?>
<td>
 <label class="sp_txtfiltro">Período</label> - Data Início <br>
  <input type="text" name="txtDataInicio" 
		value="<?php echo Util::request("txtDataInicio")   ?>"
		 style="width: 70px;" class="temData" onkeypress="return MascaraData(this,event);" maxlength="10" >
</td>
<td>
 Data Fim <br>
  <input onkeypress="return MascaraData(this,event);" maxlength="10" type="text"
 name="txtDataFim" 
		value="<?php echo Util::request("txtDataFim")   ?>"
		 style="width: 70px;" class="temData" >
</td>