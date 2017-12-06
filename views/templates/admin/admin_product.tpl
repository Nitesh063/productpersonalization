
<style type="text/css">
  .thumb_row{ width: 100%;margin: 0 auto;height: auto;padding: 0px 0 10px 0;} 
  .thumb_col{ width: 50px; height:auto;float: left; text-align: center;margin: 0 5px 0 5px;} 
  .thumb_col img{ clear:both;  width: 50px; height:50px;} 
  .thumb_col input{ clear:both;  width: auto; height:10px;margin-bottom:10px;} 
  .main_img { clear: both; } 
  .main_img img { max-width : 100%; height : auto; } 
</style>
{if $show_product_warning}
    <div class="alert alert-warning">
        <button data-dismiss="alert" class="close" type="button">×</button>
        {l s='There is 1 warning.' mod='productpersonalisation'}
        <ul id="seeMore" style="display:block;">
            <li>{l s='Product is not a customizable.' mod='productpersonalisation'}</li>
        </ul>
    </div>
{else}       
    <div class="panel product-tab">
            <input type="hidden" name="total_custom_tabs" value="{math equation='x+y' x=$tabb y=1}">
            {for $tab=0 to $tabb}
            <div id="tabb" class="tab_{$tab}">
                            {if isset($thumbs_data)}
                                <div class="thumb_row">
                                {foreach $thumbs_data as $thumb_data}
                                         <div class="thumb_col">
                                                 <img  id="thumb_{$thumb_data.image_id}" src="http://{$thumb_data.thumb_imagePath}" alt=""  alt="" title="" width="50" height="50"  />
                                                 <input type="radio" class="imgchange" name="id_image_{$tab}" value="{$thumb_data.image_id}" data-pii="{$product_image_id.$tab}" {if isset($product_image_id.$tab) && $product_image_id.$tab == $thumb_data.image_id} checked="checked" {/if} />
                                        </div>
                                        
                                {/foreach}
                                </div>

                               
                            {/if}
        
                {*<h3>{l s='Customisation Area' mod='productpersonalisation'}</h3>*}
                <div class="form-group">
                    <input type="button" class="btn pull-right red" value="Delete Tab" data-val="{$tab}" onclick="return removeThisTab($(this));" id="deleteTab">
                    <label style="float:left; text-align:left" class="control-label col-lg-12" for="cartproduct_autocomplete_input">
                        {l s='Select the customizable area! ' mod='productpersonalisation'}
                    </label>
                    <br>
                    <div class="col-lg-12">
                        <div class="col-lg-7">
                                
                                <div class="frame main_img" >
                                    <img id="photo" class="photo_{$tab}" src="http://{$product_image.$tab}" alt="image" width="{$largeSize.width}" height="{$largeSize.height}"/>
                                </div>

                       
                        </div>
                        <div class="col-lg-5">
                         
                                {*<div class="frame"  style="margin: 0 1em; width: 100px; height: 100px;">
                                    <div  id="preview" style="width: 100px; height: 100px; overflow: hidden;">
                                        <img  src="http://{$product_image}">
                                    </div>
                                </div> *}
                                <div class="newtable_bg">
                                    <table style="margin-top: 1em;">
                                        <thead>
                                            <tr>
                                                <th style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;" colspan="2">
                                                    Coordinates
                                                </th>
                                                <th style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;" colspan="2">
                                                    Dimensions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 15%;"><b>X<sub>1</sub>:</b></td>
                                                <td style="width: 33%; padding-right:4%;"><input type="text" name="p_x1_{$tab}"  value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.product_x1}{/if}" id="x1"></td>
                                                <td style="width: 20%;"><b>Width:</b></td>
                                                <td><input type="text" name="p_width_{$tab}"  id="w" value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.product_width}{/if}"></td>
                                            </tr>
                                            <tr>
                                                <td><b>Y<sub>1</sub>:</b></td>
                                                <td style="width: 33%; padding-right:4%;"><input type="text" name="p_y1_{$tab}" value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.product_y1}{/if}" id="y1"></td>
                                                <td><b>Height:</b></td>
                                                <td><input type="text" name="p_height_{$tab}" value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.product_height}{/if}" id="h"></td>
                                            </tr>
                                            <tr>
                                                <td><b>X<sub>2</sub>:</b></td>
                                                <td style="width: 33%; padding-right:4%;"><input type="text" name="p_x2_{$tab}" value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.product_x2}{/if}" id="x2"></td>
                                                <td><b>Aspect Ratio:</b></td>
                                                <td><input type="text" name="p_aspectRatio_{$tab}" value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.aspectRatio}{/if}" id="aspectRatio"></td>
                                            </tr>
                                            <tr>
                                                
                                                <td><b>Y<sub>2</sub>:</b></td>
                                                <td style="width: 33%; padding-right:4%;"><input type="text"  name="p_y2_{$tab}" value="{if isset($customised_values) && !empty($customised_values)}{$customised_values.$tab.product_y2}{/if}" id="y2"></td>
                                                <td colspan="2" align="right"><input type="button" class="btn" value="Apply Ratio" id="aspectRatioButton" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-lg-5 text-left" for="customization_type">{l s='Customization type' mod='productpersonalisation'}</label>
                                    <div class="col-lg-7">
                                        <select name="customization_type_{$tab}" id="customization_type" onchange="return toggleOtherFields($(this));">
                                        {foreach from=$customization_type key=key item=option}
                                            <option value="{$key}" {if $customised_values.$tab.custom_type == $key } selected="selected" {/if}>{$option}</option>
                                        {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group hidden">
                                    <label class="col-lg-3" for="placeholder">{l s='Default value' mod='productpersonalisation'}</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="placeholder" class="form-control  updateCurrentText " name="placeholder_{$tab}" value="{$customised_values.$tab.default_value}">   
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <label class="col-lg-3" for="character_limit">{l s='Default value' mod='productpersonalisation'}</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="character_limit" class="form-control" name="character_limit_{$tab}" value="{$customised_values.$tab.character_limit}">   
                                    </div>
                                </div>
                      
                        </div>

                    </div> 
                </div>
            </div>
            <hr>
            {/for}
         <div class="panel-footer">
        <a class="btn btn-default" href="index.php?controller=AdminProducts&token={$smarty.get.token}"><i class="process-icon-cancel"></i> {l s='Cancel' mod='productpersonalisation'}</a>
        <a class="btn btn-default" onclick="return addNewSection();" href="#"><i class="process-icon-new"></i> {l s='Add new section' mod='productpersonalisation'}</a>
        <button class="btn btn-default pull-right" name="submitAddproduct" type="submit"><i class="process-icon-save"></i> {l s='Save' mod='productpersonalisation'}</button>
        <button class="btn btn-default pull-right" name="submitAddproductAndStay" type="submit"><i class="process-icon-save"></i> {l s='Save and stay' mod='productpersonalisation'}</button>
        </div>
    </div>
{/if}
<input type="hidden" value="informations" id="key_tab" name="key_tab">
<script type="text/javascript">
$(document).ready(function() {
    $('#tabb .imgchange').each(function(){
        $(this).on({
            'click': function(){
                $(this).parents('#tabb').find('#photo').attr('src', $(this).parent().find('img').attr('src'));
                $(window).resize();
            }
        });
    });
 });
</script>