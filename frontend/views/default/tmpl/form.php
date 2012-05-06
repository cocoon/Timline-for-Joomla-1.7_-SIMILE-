<?php defined('_JEXEC') or die('Restricted access'); ?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		// do field validation
		if (form.text.value == "") {
			alert( "<?php echo JText::_( 'Auto must have a text', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="110" class="key">
				<label for="title">
					<?php echo JText::_( 'Text' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="text" id="text" size="60" value="<?php echo $this->message->msg; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="alias">
					<?php echo JText::_( 'Manufacturer' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="hersteller" id="hersteller" size="60" value="<?php echo $this->message->fromname; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'Photo klein (120px)' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="photo_klein" id="photo_klein" size="60" value="<?php echo $this->message->id; ?>" />
				<?php echo JText::_( '(please insert a link with http:// to an existing photo)' ); ?>
			</td>
		</tr>
		<tr>
		   <td colspan="2">
		   <?php if ($this->message->id){?>
		      <img src="<?php echo $this->message->id; ?>">	
		   <?php } ?>
		   </td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'Photo gross (350px)' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="photo_gross" id="photo_gross" size="60" value="<?php echo $this->message->id; ?>" />
				<?php echo JText::_( '(please insert a link with http:// to an existing photo)' ); ?>
			</td>
		</tr>
		<tr>
		   <td colspan="2">
		   <?php if ($this->message->id){?>
		      <img src="<?php echo $this->message->id; ?>">	
		   <?php } ?>
		   </td>
		</tr>
		<tr>
			<td width="120" class="key">
				<?php echo JText::_( 'Published' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $this->message->published ); ?>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_sitemessenger" />
<input type="hidden" name="id" value="<?php echo $this->message->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="message" />
</form>
