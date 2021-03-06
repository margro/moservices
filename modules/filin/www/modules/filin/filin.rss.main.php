<?php
	class rssFilinView extends rssSkinHTile
{
	const itemUnFocusBgColor = '34:34:34';
	const itemFocusBgColor   = '250:175:20';
	const itemBackgroundColor = '34:34:34';
	const backgroundColor = '34:34:34';
	const topBackground = 'filin/filin_left.jpg';
	const bottomBackground = 'filin/filin_left.jpg';
	const imageFocus	= 'filin/filin_focus.jpg';
	const imageUnFocus	= 'filin/filin_bg.jpg';
	const background	= 'filin/filin_bg.jpg';
	const itemWidth		= 235;
	const itemHeight	= 420;
	const itemRows		= 1;
	const itemColums	= 5;
	//
	// ------------------------------------
	public $fields = array(
		array(				// cursor
			'type'    => 'text',
			'posX'    => 1,
			'posY'    => 16,
			'width'   => 235,
			'height'  => 386,
			'bgColor' => 'bgcolor',
			'cornerRounding' => '6',
			'content' => ''
		),
		array(				// image
			'type'    => 'image',
			'posX'    => 7,
			'posY'    => 30,
			'width'   => 221,
			'height'  => 358,
			'content' => '
	<script>
	  getStringArrayAt(imageArray, idx);
	</script>'
		),
	);
	//
	// ------------------------------------
	public $topTitle =
'
	<script>
	  topTitle;
	</script>';
	//
	// ------------------------------------
	public $bottomTitle =
'
	<script>
	  btmTitle;
	</script>';
	//
	// ------------------------------------

	public function showItemDisplay()
	{
?>
    <itemDisplay>
      <script>
	idx = getQueryItemIndex();
	drawState = getDrawingItemState();
	if (drawState == "unfocus")
	{
print( "bla unfocus" );
		color = "<?= static::unFocusFontColor ?>";
		bgcolor = "<?= static::itemUnFocusBgColor ?>";
	}
	else
	{
		color = "<?= static::focusFontColor ?>";
		bgcolor = "<?= static::itemFocusBgColor ?>";
print( "bla focus" );

		movieTitle = getStringArrayAt(titleArray, idx);
		movieDesc  = getStringArrayAt(descArray,  idx);
		movieGenre = getStringArrayAt(genreArray, idx);
		movieInfo = getStringArrayAt(infoArray, idx);
	}
print( "bla end" );
      </script>
<?php
		foreach( $this->fields as $info )
		{
			$px = round(( $info['posX']   + 0.5 ) / static::itemWidth * 100, 4);
			$py = round(( $info['posY']   + 0.5 ) / static::itemHeight * 100, 4);
			$pw = round(( $info['width']  + 0.5 )  / static::itemWidth  * 100, 4);
			$ph = round(( $info['height'] + 0.5 ) / static::itemHeight * 100, 4);

			if( $info['type'] == 'image' )
			{

?>
      <image offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>" ><?= $info['content'] ?> 
      </image>
<?php
			}
			else
			{
				$pa = isset( $info['align'] )    ? $info['align']     : static::itemTextAlign;
				$ps = isset( $info['fontSize'] ) ? $info['fontSize']  : static::itemTextFontSize;
				$pb = isset( $info['bgColor'] )  ? $info['bgColor']   : '"'. static::itemTextBackgroundColor .'"';
				$pf = isset( $info['fgColor'] )  ? $info['fgColor']   : 'color';

				$pl = isset( $info['lines'] ) ? $info['lines'] : static::itemTextLines;
				$pl = ( $pl > 0 ) ? ' lines="'. $pl .'"' : '';

				$pl .= isset( $info['rolling'] ) ? ' rolling="'. $info['rolling'] .'"' : '';
				$pl .= isset( $info['cornerRounding'] ) ? ' cornerRounding="'. $info['cornerRounding'] .'"' : '';

?>
      <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
       align="<?= $pa ?>"<?= $pl ?> fontSize="<?= $ps ?>">
	<backgroundColor>
          <script>
            <?= $pb ?>;
          </script>
	</backgroundColor>
	<foregroundColor>
          <script>
            <?= $pf ?>;
          </script>
	</foregroundColor><?= $info['content'] ?> 
      </text>
<?php
			}
		}

		// more item's fields
		$this->showMoreItemDisplay();

?>
    </itemDisplay>
<?
	}
	//
	// ------------------------------------
	function showMoreDisplay()
	{
?>
<!--
	sort title
-->
<?php
		$px = round( 780.5 / static::viewAreaWidth  * 100, 4);
		$py = round( static::topY / static::viewAreaHeight * 100, 4);
		$pw = round( 500.5 / static::viewAreaWidth  * 100, 4);
		$ph = round(  40.5 / static::viewAreaHeight * 100, 4);

?>
    <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
     redraw="yes" align="right" lines="1" fontSize="14"
     backgroundColor="-1:-1:-1"
     foregroundColor="200:200:200">
      <script>
	sortTitle;
      </script>
    </text>
<!--
	pages title
-->
<?php
		$px = round( 780.5 / static::viewAreaWidth  * 100, 4);
		$py = round( static::bottomY / static::viewAreaHeight * 100, 4);
		$pw = round( 500.5 / static::viewAreaWidth  * 100, 4);
		$ph = round(  40.5 / static::viewAreaHeight * 100, 4);

?>
    <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
     redraw="yes" align="right" lines="1" fontSize="14"
     backgroundColor="-1:-1:-1"
     foregroundColor="200:200:200">
      <script>
	pageTitle;
      </script>
    </text>
<!--
	not found message
-->
    <text redraw="yes" align="center" lines="1" fontSize="22"
     offsetXPC="18.2353" offsetYPC="15.625" widthPC="63.5294" heightPC="7.8125"
     backgroundColor="-1:-1:-1"
     foregroundColor="<?= static::unFocusFontColor ?>">
      <script>
	msgText;
      </script>
    </text>
<!--
	current movie
	delimiter
-->
<?php
		$px = 0;
		$py = round( 486.5 / static::viewAreaHeight * 100, 4);
		$pw = 100; 
		$ph = round( 3.5 / static::viewAreaHeight * 100, 4);

?>
    <image offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>">
      <?= getSkinPath() . static::topBackground ?> 
    </image>
<!--
	movies title
-->
<?php
		$px = round( 100.5 / static::viewAreaWidth  * 100, 4);
		$py = round( 490.5 / static::viewAreaHeight * 100, 4); #590
		$pw = round( 1180.5 / static::viewAreaWidth  * 100, 4);
		$ph = round(  42.5 / static::viewAreaHeight * 100, 4);
/*
     backgroundColor="<?= static::itemUnFocusBgColor ?>"
*/

?>
    <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
     redraw="yes" align="left" lines="1" fontSize="16"
     backgroundColor="<?= static::itemUnFocusBgColor ?>"
     foregroundColor="<?= static::unFocusFontColor ?>">
      <script>	movieTitle; </script>
    </text>
<!--
	movies info
-->
<?php
		$px = round( 1075.5 / static::viewAreaWidth  * 100, 4);
		$py = round( 533.5 / static::viewAreaHeight * 100, 4);
		$pw = round( 200.5 / static::viewAreaWidth  * 100, 4);
		$ph = round(  32.5 / static::viewAreaHeight * 100, 4);
?>
    <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
     redraw="yes" align="right" lines="1" fontSize="14"
	 backgroundColor="<?= static::itemUnFocusBgColor ?>"
	 foregroundColor="160:160:160">
      <script>
	movieInfo;
      </script>
    </text>
<!--
	movies genre
-->
<?php
		$px = round( 100.5 / static::viewAreaWidth  * 100, 4);
		$py = round( 533.5 / static::viewAreaHeight * 100, 4);
		$pw = round( 974.5 / static::viewAreaWidth  * 100, 4);
		$ph = round(  32.5 / static::viewAreaHeight * 100, 4);
?>
    <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
     redraw="yes" align="left" lines="1" fontSize="14"
     backgroundColor="<?= static::itemUnFocusBgColor ?>"
     foregroundColor="160:160:160">
      <script>
	movieGenre;
      </script>
    </text>
<!--
	movies description
-->
<?php
		$px = round(  100.5 / static::viewAreaWidth  * 100, 4);
		$py = round(  566.5 / static::viewAreaHeight * 100, 4);
		$pw = round( 1175.5 / static::viewAreaWidth  * 100, 4);
		$ph = round(   134.5 / static::viewAreaHeight * 100, 4);

?>
    <text offsetXPC="<?= $px ?>" offsetYPC="<?= $py ?>" widthPC="<?= $pw ?>" heightPC="<?= $ph ?>"
     redraw="yes" align="left" lines="4" fontSize="15"
     backgroundColor="<?= static::itemUnFocusBgColor ?>"
	 foregroundColor="180:180:180">
      <script>	movieDesc; </script>
    </text>

<?php
	}
	//
	// ------------------------------------
	function showDisplay()
	{
		$sw = static::screenWidth;
		$sh = static::screenHeight;

		$kw = static::skinWidth;
		$kh = static::skinHeight;

		$sx = ($sw - $kw)/2;
		$sy = ($sh - $kh)/2;

		$vx = static::viewAreaX;
		$vy = static::viewAreaY;
		$vw = static::viewAreaWidth;
		$vh = static::viewAreaHeight;

		$iw = static::itemWidth;
		$ih = static::itemHeight;

		$nc = static::itemColums;
		$nr = static::itemRows;

		$ix = ( $vw - $iw * $nc )/2;
		$iy = static::topHeight + static::topY;

		$this->_columnCount = $nc;
		$this->_rowCount = $nr;

?>
  <mediaDisplay name="photoView"

   viewAreaXPC="<?= round(( $sx + $vx + 0.5 ) / $sw * 100, 4) ?>"
   viewAreaYPC="<?= round(( $sy + $vy + 0.5 ) / $sh * 100, 4) ?>"
   viewAreaWidthPC="<?=  round(( $vw + 0.5 ) / $sw * 100, 4) ?>"
   viewAreaHeightPC="<?= round(( $vh + 0.5 ) / $sh * 100, 4) ?>"

   backgroundColor="<?= static::backgroundColor ?>"

   sideTopHeightPC="0"
   sideBottomHeightPC="0"

   sideColorBottom="<?= static::sideColorBottom ?>"
   sideColorTop="<?= static::sideColorTop ?>"

   rowCount="<?= $nr ?>"
   columnCount="<?= $nc ?>"

   itemOffsetXPC="<?= round( ( $ix + 0.5 ) / $vw * 100, 4) ?>"
   itemOffsetYPC="<?= round( ( $iy + 0.5 ) / $vh * 100, 4) ?>"
   itemWidthPC="<?=   round( ( $iw + 0.5 ) / $vw * 100, 4) ?>"
   itemHeightPC="<?=  round( ( $ih + 0.5 ) / $vh * 100, 4) ?>"

   itemGapXPC="0"
   itemGapYPC="0"

   itemBackgroundColor="<?= static::itemBackgroundColor ?>"

   sliding="no"
   rollItems="no"
   drawItemText="no"
   forceFocusOnItem="yes"

   showHeader="no"
   showDefaultInfo="no"

   idleImageXPC="<?=      round(( static::idleImageX + 0.5 ) / $vw * 100, 4) ?>"
   idleImageYPC="<?=      round(( static::idleImageY + 0.5 ) / $vh * 100, 4) ?>"
   idleImageWidthPC="<?=  round(( static::idleImageWidth  + 0.5 ) / $vw * 100, 4) ?>"
   idleImageHeightPC="<?= round(( static::idleImageHeight + 0.5 ) / $vh * 100, 4) ?>"
  >
<?php
		$this->showIdleBg();
		$this->showTop();
		$this->showBottom();
		$this->showMoreDisplay();
		$this->showItemDisplay();
		$this->showOnUserInput();

?>
  </mediaDisplay>
<?php
}
	//
	// ------------------------------------
	public function showOnUserInput()
	{

?>
    <onUserInput>

	ret = "false";
	i = getFocusItemIndex();
	userInput = currentUserInput();

	if (userInput == "<?= getRssCommand('up') ?>")
	{
		if( ( i % <?= $this->_rowCount ?> ) == 0 ) ret = "true";
	}

	else if (userInput == "<?= getRssCommand('down') ?>")
	{
		if( ( ( i - -1 ) % <?= $this->_rowCount ?> ) == 0 ) ret = "true";
	}

	else if (userInput == "<?= getRssCommand('left') ?>")
	{
		if( actPrev != "" )
		if( i &lt; <?= $this->_rowCount ?> )
		{
			moUrl = actPrev;
			savedItem = i - ( <?= $this->_rowCount ?> - itemCount );
			setRefreshTime(100);
			ret = "true";
		}
	}

	else if (userInput == "<?= getRssCommand('right') ?>")
	{
		if( actNext != "" )
		if( i &gt; ( itemCount - <?= $this->_rowCount ?> - 1 ) )
		{
			moUrl = actNext;
			savedItem = i - ( itemCount - <?= $this->_rowCount ?> );
			setRefreshTime(100);
			ret = "true";
		}
	}
	else if (userInput == "<?= getRssCommand('video_ffwd') ?>")
	{
			izb = getStringArrayAt(idArray, i);
			url = "<?= getMosUrl().'?page=filin_izb' ?>" + "&amp;id=" + izb;
			doModalRss( url );
			if (id_page == "1" || id_page == 1 ) setRefreshTime(100);
	}
	else if (userInput == "<?= getRssCommand('play') ?>" || userInput == "<?= getRssCommand('enter') ?>")
	{
		showIdle();
		id = getStringArrayAt(idArray, i);
		url = "<?= getMosUrl().'?page=rss_filin_info' ?>" + "&amp;url=" + id;
		doModalRss( url );
		cancelIdle();
		ret = "true";
	}
	else if (userInput == "<?= getRssCommand('menu') ?>" || userInput == "menu" || userInput == "<?= getRssCommand('rewind') ?>")
	{
	        url = "<?= getMosUrl().'?page=rss_filin_menu' ?>";

		url = doModalRss( url );
		if(( url != null )&amp;&amp;( url != "" ))
		{
			moUrl = url;
			savedItem = 0;
			setRefreshTime(100);
		}
		ret = "true";
	}
	ret;
    </onUserInput>
<?php
	}
	//
	// ------------------------------------
	public function showScripts()
	{
?>

  <onEnter>
	moUrl = "<?= getMosUrl().'?page=filin_list' ?>";
	savedItem = 0;

	movieTitle = "";
	movieDesc  = "";
	movieGenre = "";

	setRefreshTime(100);

  </onEnter>

  <onRefresh>
	setRefreshTime(-1);

	/* load list */
	showIdle();
	dlok = getURL( moUrl );
	if ( dlok != null &amp;&amp; dlok != "" ) dlok = readStringFromFile( dlok );
	if ( dlok != null &amp;&amp; dlok != "" )
	{
		itemCount = 0;

		c = 0;
		id_page = getStringArrayAt(dlok, c); c += 1;
		topTitle = getStringArrayAt(dlok, c); c += 1;
		btmTitle = getStringArrayAt(dlok, c); c += 1;

		sortTitle = getStringArrayAt(dlok, c); c += 1;
		pageTitle = getStringArrayAt(dlok, c); c += 1;

		actPrev = getStringArrayAt(dlok, c); c += 1;
		actNext = getStringArrayAt(dlok, c); c += 1;

		itemCount = getStringArrayAt(dlok, c); c += 1;

		idArray    = null;
		titleArray = null;
		imageArray = null;
		descArray  = null;
		genreArray = null;
		infoArray =  null;
		
		count = 0;
		while( count != itemCount )
		{
			idArray    = pushBackStringArray( idArray,    getStringArrayAt(dlok, c)); c += 1;
			titleArray = pushBackStringArray( titleArray, getStringArrayAt(dlok, c)); c += 1;
			imageArray = pushBackStringArray( imageArray, getStringArrayAt(dlok, c)); c += 1;
			descArray  = pushBackStringArray( descArray,  getStringArrayAt(dlok, c)); c += 1;
			genreArray = pushBackStringArray( genreArray, getStringArrayAt(dlok, c)); c += 1;
			infoArray = pushBackStringArray( infoArray, getStringArrayAt(dlok, c)); c += 1;
			count += 1;
		}
	}
	msgText = "";
	if( itemCount == 0 )
	{
		msgText = "<?= getMsg('coreRssPromptNothing') ?>";
		setFocusItemIndex( 0 );
	}
	else
	{
		if( savedItem &gt; ( itemCount - 1 )) setFocusItemIndex( itemCount - 1 );
		else setFocusItemIndex( savedItem );
	}
	cancelIdle();

	redrawDisplay();
	null;
  </onRefresh>

  <onExit>
	setRefreshTime(-1);
    	playItemURL(-1, 1);
  </onExit>

<?php
	}
	//
	// ------------------------------------
	public function showChannel()
	{
?>
  <channel>
    <itemSize>
      <script>
	itemCount;
      </script>
    </itemSize>
  </channel>
<?php
	}
}
?>