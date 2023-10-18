[{$smarty.block.parent}]
<tr>
    <td colspan="2">
        <br/><br/>
        <fieldset title="[{oxmultilang ident="ARTICLE_EXTEND_MEDIAURLS"}]" style="padding-left: 5px;">
            <legend>[{oxmultilang ident="ARTICLE_EXTEND_MEDIAURLS"}]</legend><br>

            <table cellspacing="0" cellpadding="0" border="0">
                [{block name="admin_category_extend_media"}]
                [{foreach from=$aMediaUrls item=oMediaUrl}]
                <tr>
                    [{if $oddclass == 2}]
                    [{assign var=oddclass value=""}]
                    [{else}]
                    [{assign var=oddclass value="2"}]
                    [{/if}]
                    <td class=listitem[{$oddclass}]>
                        &nbsp;<a href="[{$oMediaUrl->getLink()}]" target="_blank">&raquo;&raquo;</a>&nbsp;
                    </td>
                    <td class=listitem[{$oddclass}]>
                        &nbsp;<a href="[{$oViewConf->getSelfLink()}]&cl=category_main&amp;mediaid=[{$oMediaUrl->oxmediaurls__oxid->value}]&amp;fnc=deletemedia&amp;oxid=[{$oxid}]&amp;editlanguage=[{$editlanguage}]" onClick='return confirm("[{oxmultilang ident="GENERAL_YOUWANTTODELETE"}]")'><img src="[{$oViewConf->getImageUrl()}]/delete_button.gif" border=0></a>&nbsp;
                    </td>
                    <td class="listitem[{$oddclass}]" width=250>
                        <input style="width:100%" class="edittext" type="text" name="aMediaUrls[[{$oMediaUrl->oxmediaurls__oxid->value}]][oxmediaurls__oxdesc]" value="[{$oMediaUrl->oxmediaurls__oxdesc->value}]" [{$readonly}]>
                    </td>
                </tr>
                [{/foreach}]

                [{if $aMediaUrls->count()}]
                <tr>
                    <td colspan="3" align="right">
                        <input class="edittext" type="button" onclick="this.form.fnc.value='updateMedia';this.form.submit();" [{$readonly}] value="[{oxmultilang ident="ARTICLE_EXTEND_UPDATEMEDIA"}]" [{$readonly}]>
                        <br><br>
                    </td>
                </tr>
                [{/if}]

                <tr>
                    <td colspan="3">
                        [{oxmultilang ident="ARTICLE_EXTEND_DESCRIPTION"}]:<br>
                        <input style="width:100%" type="text" name="mediaDesc" class="edittext" [{$readonly}]>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        [{oxmultilang ident="ARTICLE_EXTEND_ENTERURL"}]:<br>
                        <input style="width:100%" type="text" name="mediaUrl" class="edittext" [{$readonly}]>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        [{oxmultilang ident="ARTICLE_EXTEND_UPLOADFILE"}]:<br>
                        <input style="width:100%" type="file" name="mediaFile" class="edittext" [{$readonly}]>
                    </td>
                </tr>
                [{/block}]
            </table>

        </fieldset>
    </td>
</tr>