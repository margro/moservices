<?php
/*	------------------------------
	Ukraine online services 	
	RSS history module v1.2
	------------------------------
	Created by Sashunya 2013
	wall9e@gmail.com			
	Some code was used from 
	Farvoice & others 
	------------------------------ */

include( 'ua_rss_view.php' );
class ua_rss_favorites2 extends ua_rss_list_const
{
	const itemdisplay_widthPC	=	'80';
	
	const item_site_display_offsetXPC	=	'90';
	const item_site_display_offsetYPC	=	'20';
	const item_site_display_widthPC		=	'6';
	const item_site_display_heightPC	=	'50';

}
class ua_rss_favorites  extends ua_rss_favorites2
{
	// функция вставляет бордюры все картинки и текст
	//-------------------------------
	public function mediaDisplay_content()
	{
	global $ua_images_path;
	global $ua_path_link;
	global $ua_images_foldername;
	?>
			
	<text  align="<?= static::text_header_align ?>" redraw="<?= static::text_header_redraw ?>" lines="<?= static::text_header_lines ?>" offsetXPC="<?= static::text_header_offsetXPC ?>" offsetYPC="<?= static::text_header_offsetYPC ?>" widthPC="<?= static::text_header_widthPC ?>" heightPC="<?= static::text_header_heightPC ?>" fontSize="<?= static::text_header_fontSize ?>" backgroundColor="<?= static::text_header_backgroundColor ?>" foregroundColor="<?= static::text_header_foregroundColor ?>">
		История просмотров
	</text>
	
	<text  align="<?= static::text_footer_align ?>" redraw="<?= static::text_footer_redraw ?>" lines="<?= static::text_footer_lines ?>" offsetXPC="<?= static::text_footer_offsetXPC ?>" offsetYPC="<?= static::text_footer_offsetYPC ?>" widthPC="<?= static::text_footer_widthPC ?>" heightPC="<?= static::text_footer_heightPC ?>" fontSize="<?= static::text_footer_fontSize ?>" backgroundColor="<?= static::text_footer_backgroundColor ?>" foregroundColor="<?= static::text_footer_foregroundColor ?>">
		
	</text>
	<scrollbar offsetXPC=93 offsetYPC=13 widthPC=2.26 heightPC=75.0 backgroundImage="<?=$ua_path_link.$ua_images_foldername?>ua_scroll_bar_01.png" foregroundImage="<?=$ua_path_link.$ua_images_foldername?>ua_scroll_bar_02.png" border=7 offset=0 direction="vertical" redraw="yes">
		<totalSize>
			<script>
				getPageInfo("itemCount");
			</script>
		</totalSize>
		<startIndex>
			<script>
				getFocusItemIndex();
			</script>
		</startIndex>
	</scrollbar>
	<?php	
		
	}
	// функция выводит список фильмов
	//-------------------------------
	public function itemDisplay_content()
	{
	global $ua_path_link;
	?>
	<image  offsetXPC="<?= static::item_image_display_offsetXPC ?>" offsetYPC="<?= static::item_image_display_offsetYPC ?>" widthPC="<?= static::item_image_display_widthPC ?>" heightPC="<?= static::item_image_display_heightPC ?>">
			<script> getStringArrayAt(imageBookArray,idx);</script>
	</image>
	
	<text offsetXPC="<?= static::itemdisplay_offsetXPC ?>" offsetYPC="<?= static::itemdisplay_offsetYPC ?>" widthPC="<?= static::itemdisplay_widthPC ?>" heightPC="<?= static::itemdisplay_heightPC ?>" fontSize="<?= static::itemdisplay_fontSize ?>" lines="<?= static::itemdisplay_lines ?>">
		<foregroundColor>
			<script>
				if (bookCount !=0 ){
					cnt = 0;
					blink = getStringArrayAt(linkBookArray,idx); 
					while( cnt != bookCount )
					{
						bookLink=getStringArrayAt(linkArray, cnt);
						if (bookLink == blink) 
						{
							color = "255:239:69";
							break;
						}
						
						cnt += 1;
						
					}	
					print("blink =======",blink);
					print("bookLink =======",bookLink);
				}
				color;
			</script>
		</foregroundColor>
	    <script> 
					getStringArrayAt(titleBookArray,idx);
		</script>
	</text>	
	<image  offsetXPC="<?= static::item_site_display_offsetXPC ?>" offsetYPC="<?= static::item_site_display_offsetYPC ?>" widthPC="<?= static::item_site_display_widthPC ?>" heightPC="<?= static::item_site_display_heightPC ?>">
			<script>
				site_logo=getStringArrayAt(sitelogoArray,getStringArrayAt(siteBookArray,idx));
				site_logo;
			</script>
	</image>
	<?php
	}
	//-------------------------------
	public function onRefresh()
	{
	global $ua_path;
	global $ua_path_link;
	global $exua_parser_filename;
	global $ua_history_main_filename;
	global $ua_favorites_filename;
	?>
	<onRefresh>
		setRefreshTime(-1);    
		showIdle();
		itemCount = 0;
		historyFilesListArray = null;
		titleBookArray =  null;
		linkBookArray = null;
		imageBookArray = null;
		siteBookArray = null;
		typeBookArray = null;
		menuArray = null;
		menucmdArray = null;
		menuCount = 4;
		menuArray = pushBackStringArray( menuArray, "В избранное");
		menucmdArray = pushBackStringArray( menucmdArray, "bookmark");
		menuArray = pushBackStringArray( menuArray, "Удалить");
		menucmdArray = pushBackStringArray( menucmdArray, "delete");
		menuArray = pushBackStringArray( menuArray, "Очистить ист.");
		menucmdArray = pushBackStringArray( menucmdArray, "clear");
		menuArray = pushBackStringArray( menuArray, "Выход");
		menucmdArray = pushBackStringArray( menucmdArray, "exit");
			
		dlok = readStringFromFile( "<?=$ua_history_main_filename?>" );
		if (dlok != null)
			{
				c = 0;
				itemCount = getStringArrayAt(dlok, c);
				count = itemCount;
				c = (count*5)-4);
				while( count != 0 )
					{
					linkBookArray = pushBackStringArray(linkBookArray, getStringArrayAt(dlok, c));  c -= -1;
					historyFilesListArray = pushBackStringArray(historyFilesListArray, getStringArrayAt(dlok, c));  c -= -1;
					titleBookArray = pushBackStringArray(titleBookArray, getStringArrayAt(dlok, c));  c -= -1;
					imageBookArray = pushBackStringArray(imageBookArray, getStringArrayAt(dlok, c));  c -= -1;
					siteBook=getStringArrayAt(dlok, c);
					siteBookArray = pushBackStringArray(siteBookArray,siteBook );  c -= -1;
					typeBookArray = pushBackStringArray(typeBookArray, "link"); 
					count -= 1;
					c = (count*5)-4;
					}
			}
		cancelIdle();
		tmp_index =itemCount-1;
		if (itm_index &gt; tmp_index) itm_index = tmp_index;
		
		titleArray = null;
		linkArray = null;
		imageArray = null;
		typeArray = null;
		siteArray = null;
		bookCount = 0;
		dlok = readStringFromFile( "<?=$ua_favorites_filename?>" );
		if (dlok != null)
			{
				c = 0;
				bookCount = getStringArrayAt(dlok, c); c += 1;
				count = 0;
				while( count != bookCount )
					{
					titleArray = pushBackStringArray(titleArray, getStringArrayAt(dlok, c));  c += 1;
					linkArray = pushBackStringArray(linkArray, getStringArrayAt(dlok, c));  c += 1;
					imageArray = pushBackStringArray(imageArray, getStringArrayAt(dlok, c));  c += 1;
					typeArray = pushBackStringArray(typeArray, getStringArrayAt(dlok, c));  c += 1;					
					siteArray = pushBackStringArray(siteArray, getStringArrayAt(dlok, c));  c += 1;					
					count += 1;
					}
										
			}	
		
		
		setFocusItemIndex(itm_index);
		setFocusMenuIndex(menu);
		redrawDisplay();
	</onRefresh>
	<?php
	}
	//-------------------------------
	public function menu()
	{
	global $ua_path;
	global $ua_path_link;
	global $exua_parser_filename;
	global $key_return;
	global $ua_rss_keyboard_filename;
	global $ua_favorites_filename;
	global $ua_history_main_filename;
	global $confs_path;
	?>
	<menu_template>
	<displayTitle>
		<script>
			getStringArrayAt( menuArray , getQueryMenuIndex() );
		</script> 
	</displayTitle>
	<onClick>
		showIdle();
		idx = getFocusItemIndex();
		act = getStringArrayAt( menucmdArray , menu );
		if (act == "exit") postMessage("<?=$key_return?>");
		if (act == "bookmark") {
			idx = getQueryItemIndex();
			btitle = getStringArrayAt(titleBookArray,idx);
			blink = getStringArrayAt(linkBookArray,idx);
			bimage = getStringArrayAt(imageBookArray,idx);
			bsitelink = getStringArrayAt(siteBookArray,idx);
			btype = getStringArrayAt(typeBookArray,idx);
			titleArray = pushBackStringArray(titleArray, btitle);
			imageArray = pushBackStringArray(imageArray, bimage);
			linkArray = pushBackStringArray(linkArray, blink);
			typeArray = pushBackStringArray(typeArray, btype);
			siteArray = pushBackStringArray(siteArray, bsitelink);
			saveBookArray = null;
			bookCount -= -1;
			saveBookArray = pushBackStringArray(saveBookArray, bookCount);
			count = 0;
			while( count != bookCount )
				{				
				saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(titleArray,count));
				saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(linkArray,count));
				saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(imageArray,count));
				saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(typeArray,count));
				saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(siteArray,count));				
				count += 1;
				}
						
			writeStringToFile("<?=$ua_favorites_filename?>", saveBookArray);
			setRefreshTime(1);
		} 
		if (act == "delete") 
		{
			histFileDel=getStringArrayAt(historyFilesListArray,idx);
			linkBookArray = deleteStringArrayAt(linkBookArray, idx);
			historyFilesListArray = deleteStringArrayAt(historyFilesListArray, idx);
			titleBookArray = deleteStringArrayAt(titleBookArray, idx);
			imageBookArray = deleteStringArrayAt(imageBookArray, idx);
			siteBookArray = deleteStringArrayAt(siteBookArray, idx);
			itemCount -=1;
			
			saveBookArray = null;
			saveBookArray = pushBackStringArray(saveBookArray, itemCount);
			count = itemCount-1;
			cnt=0;
			while( count != -1 )
				{	
					saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(linkBookArray,count));
					hst = getStringArrayAt(historyFilesListArray,count);
					tmp_hist = readStringFromFile( "<?=$confs_path."ua_history/"?>" +hst+".conf" );
					writeStringToFile("<?=$confs_path."ua_history/"?>" +cnt+".conf", tmp_hist);
					saveBookArray = pushBackStringArray(saveBookArray, cnt);
					saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(titleBookArray,count));
					saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(imageBookArray,count));
					saveBookArray = pushBackStringArray(saveBookArray, getStringArrayAt(siteBookArray,count));
					count -= 1;
					cnt +=1;
				}				
			writeStringToFile("<?=$confs_path."ua_history/"?>" +cnt+".conf", "");
			writeStringToFile("<?=$ua_history_main_filename?>", saveBookArray);
			setRefreshTime(1);
		}
		if (act == "clear") 
		{
			dlok = getURL("<?=$ua_path_link.'ua_paths.inc.php?clear=1'?>");
			setRefreshTime(1);
		}
		
		
		null;
	</onClick>
	</menu_template>
	<?php
	}
	//-------------------------------
	public function onEnters()
	{
	global $ua_path_link;
	global $sites_logos_filename;
	global $ua_images_foldername;
	?>
	<onEnter>
	returnFromLink=readStringFromFile("/tmp/env_returnFromLink_message");
	returnFromList=readStringFromFile("/tmp/env_returnFromList_message");
		if (returnFromLink == "1" || returnFromList == "1")
			{
				writeStringToFile("/tmp/env_returnFromLink_message", "");
				writeStringToFile("/tmp/env_returnFromList_message", "");
			}
		else
	{
		sitelogoArray = null;
		dlok = readStringFromFile( "<?=$sites_logos_filename?>" );
		if (dlok != null)
			{
				c = 0;
				itmCount = getStringArrayAt(dlok, c); c += 1;
				count = 0;
				while( count != itmCount )
					{
						logos = "<?=$ua_path_link.$ua_images_foldername?>"+getStringArrayAt(dlok, c);
						sitelogoArray = pushBackStringArray(sitelogoArray, logos); c += 1;
						count += 1;
					}
			}
	
		itm_index=0;
		menu=0;
		setRefreshTime(1);    
	}
	</onEnter>
	<onExit>
		writeStringToFile("/tmp/env_returnFromList_message", "1");
	</onExit>
	<?php
	}
	//-------------------------------
	public function items()
	{
	global $ua_path_link;
	?>
	<startLink>
		<link>
			<script>
				link;
			</script>
		</link>
	</startLink>
	
	
	<item_template>
		<onClick>
			<script>
				idx = getFocusItemIndex();
				link2 = getStringArrayAt( linkBookArray , idx );
				site = getStringArrayAt( siteBookArray , idx );
				type = getStringArrayAt( typeBookArray , idx );
				link1 = getURL("<?=$ua_path_link.'ua_paths.inc.php?get_fav_site='?>"+site+"&amp;get_fav_type="+type);
				link= link1+urlEncode(link2);
				jumpToLink("startLink");
			</script>
			null;
		</onClick>
	</item_template>
	<?php
	}
	//-------------------------------
	public function channel()
	{
	global $ua_path;
	global $exua_rss_list_filename;
	?>
	<channel>
	<title>HISTORY</title>
	<link></link>

	<itemSize>
		<script>
			itemCount;
		</script>
    </itemSize>
	<menuSize>
		<script>
			menuCount;
		</script>
    </menuSize>
		
	</channel>
	<?php
	}
}
//-------------------------------
$view = new ua_rss_favorites;
$view->showRss();
exit;
?>