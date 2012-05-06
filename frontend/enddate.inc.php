    <select id="EndDay" name="EndDay" onchange="QuickJump(this.form);" >
      <option value="Mon" <?php if ($row->EndDay == "Mon") { echo "selected";}?>>Mon</option>
      <option value="Tue" <?php if ($row->EndDay == "Tue") { echo "selected";}?>>Tue</option>
      <option value="Wed" <?php if ($row->EndDay == "Wed") { echo "selected";}?>>Wed</option>
      <option value="Thu" <?php if ($row->EndDay == "Thu") { echo "selected";}?>>Thu</option>
      <option value="Fri" <?php if ($row->EndDay == "Fri") { echo "selected";}?>>Fri</option>
      <option value="Sat" <?php if ($row->EndDay == "Sat") { echo "selected";}?>>Sat</option>
      <option value="Sun" <?php if ($row->EndDay == "Sun") { echo "selected";}?>>Sun</option>
    </select>
    
    <select id="EndMonth" name="EndMonth" onchange="QuickJump(this.form);" >
      <option value="Jan" <?php if ($row->EndMonth == "Jan") { echo "selected";}?>>Jan</option>
      <option value="Feb" <?php if ($row->EndMonth == "Feb") { echo "selected";}?>>Feb</option>
      <option value="Mar" <?php if ($row->EndMonth == "Mar") { echo "selected";}?>>Mar</option>
      <option value="Apr" <?php if ($row->EndMonth == "Apr") { echo "selected";}?>>Apr</option>
      <option value="May" <?php if ($row->EndMonth == "May") { echo "selected";}?>>May</option>
      <option value="Jun" <?php if ($row->EndMonth == "Jun") { echo "selected";}?>>Jun</option>
      <option value="Jul" <?php if ($row->EndMonth == "Jul") { echo "selected";}?>>Jul</option>
      <option value="Aug" <?php if ($row->EndMonth == "Aug") { echo "selected";}?>>Aug</option>
      <option value="Sep" <?php if ($row->EndMonth == "Sep") { echo "selected";}?>>Sep</option>
      <option value="Oct" <?php if ($row->EndMonth == "Oct") { echo "selected";}?>>Oct</option>
      <option value="Nov" <?php if ($row->EndMonth == "Nov") { echo "selected";}?>>Nov</option>
      <option value="Dec" <?php if ($row->EndMonth == "Dec") { echo "selected";}?>>Dec</option>
    </select>
    
    <select id="EndDateDay" name="EndDateDay" onchange="QuickJump(this.form);" >
       <?php
         $Endday = 1;
         while($Endday < 32)
           {
             echo "<option value='".$Endday."' ";
             if ($row->EndDateDay == $Endday) { echo "selected";};
             echo ">".$Endday."</option>";
             $Endday++;
            }
       ?>
     </select>

    <select id="EndDateYear" name="EndDateYear" onchange="QuickJump(this.form);" >
       <?php
         $Endyear = 1900;
         $actualyear = date('Y');
         while($Endyear < 2100)
           {
             echo "<option value='".$Endyear."' ";
             if ($row->EndDateYear == $Endyear || $Endyear == $actualyear) { echo "selected";};
             echo ">".$Endyear."</option>";
             $Endyear++;
            }
       ?>
    </select>

<input type="textfield" maxlength="8" id="EndDateTime" name="EndDateTime" value="<?php echo $row->EndDateTime; ?>"  />
<input type="textfield" maxlength="40" id="EndDateGMT" name="EndDateGMT" value="<?php echo $row->EndDateGMT; ?>"  />
