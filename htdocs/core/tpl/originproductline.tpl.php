<?php
/* Copyright (C) 2010-2012	Regis Houssin	<regis@dolibarr.fr>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
?>

<!-- BEGIN PHP TEMPLATE originproductline.tpl.php -->
<tr <?php echo $bc[$var]; ?>>
	<td><?php echo $this->tpl['label']; ?></td>
	<td><?php echo $this->tpl['description']; ?></td>
	<td align="right"><?php echo $this->tpl['vat_rate']; ?></td>
	<td align="right"><?php echo $this->tpl['price']; ?></td>
	<td align="right"><?php echo $this->tpl['qty']; ?></td>
	<td align="right"><?php echo $this->tpl['remise_percent']; ?></td>
</tr>
<!-- END PHP TEMPLATE originproductline.tpl.php -->