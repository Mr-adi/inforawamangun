<?php
/*
Plugin Name: Px Mega Menu
*/

// Hooks
add_action('wp_update_nav_menu_item', 'pixflow_nav_update',10, 3);
add_filter( 'wp_setup_nav_menu_item', 'pixflow_nav_item');
add_filter( 'wp_edit_nav_menu_walker', 'pixflow_nav_edit_walker',10,2 );
add_action( 'admin_head', 'pixflow_enqueue_Menu_Scripts');

/*
 * Saves new field to postmeta for navigation
 */
function pixflow_nav_update($menu_id, $menu_item_db_id, $args ) {


    //Enable or Disable icon
    $showIcon = isset( $_POST['menu-item-show_icon'][ $menu_item_db_id ] )? true : false;
    update_post_meta( $menu_item_db_id, '_px_menu_item_show_icon', $showIcon );

    if (isset( $_POST['menu-item-icon'][ $menu_item_db_id ]) ){
        update_post_meta( $menu_item_db_id, '_px_menu_item_icon', $_POST['menu-item-icon'][ $menu_item_db_id ] );
    }

    //value of mega option
    $value = isset( $_POST['menu-item-megaOpt'][ $menu_item_db_id ] )? true : false;
    update_post_meta( $menu_item_db_id, '_px_menu_item_megaOpt', $value );

    //value of mega align
    if (isset( $_POST['menu-item-megaAlign'][ $menu_item_db_id ]) ){
        update_post_meta( $menu_item_db_id, '_px_menu_item_megaAlign', $_POST['menu-item-megaAlign'][ $menu_item_db_id ] );
    }

    // Check that the nonce is valid, and the user can edit this post.
    if (isset( $_POST['menu_item_megaBg_nonce_'.$menu_item_db_id ] ) ) {
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        // Let WordPress handle the upload.
        $attachment_id = media_handle_upload( 'menu-item-megaBg-'.$menu_item_db_id, $menu_item_db_id );
    }

    if(isset( $_POST['input-attachment-'.$menu_item_db_id])){
        $removeAttach=$_POST['input-attachment-'.$menu_item_db_id];
        if ($removeAttach && !$_FILES['menu-item-megaBg-'.$menu_item_db_id]['name']) {

            $media = get_children(array(
                'post_parent' => $menu_item_db_id,
                'post_type' => 'attachment'
            ));

            foreach ($media as $file) {
                wp_delete_attachment($file->ID);
            }
        }
    }

}

/*
 * Adds value of new field to $item object that will be passed to     Pixflow_Walker_Nav_Menu
 */
function pixflow_nav_item($menu_item) {
    $menu_item->icon = get_post_meta( $menu_item->ID, '_px_menu_item_icon',true);
    $menu_item->megaOpt = get_post_meta($menu_item->ID,'_px_menu_item_megaOpt',true);
    $menu_item->show_icon = get_post_meta($menu_item->ID,'_px_menu_item_show_icon',true);
    $menu_item->megaAlign = get_post_meta($menu_item->ID,'_px_menu_item_megaAlign',true);
    return $menu_item;
}

function pixflow_nav_edit_walker($walker, $menu_id) {
    return 'Pixflow_Walker_Nav_Menu';
}

function pixflow_enqueue_Menu_Scripts (){
    wp_enqueue_style('admin',pixflow_path_combine(PIXFLOW_THEME_LIB_URI,'/assets/css/admin.css'),false,PIXFLOW_THEME_VERSION);

    if (! wp_script_is( 'adminJs', 'enqueued' )) {
        wp_enqueue_script('adminJs',pixflow_path_combine(PIXFLOW_THEME_LIB_URI,'/assets/script/admin.js'),false,PIXFLOW_THEME_VERSION,true);
        wp_localize_script('adminJs', 'admin_var', array(
                'addTab' => esc_attr__('ADD TAB','massive-dynamic'),
                'chooseImage' => esc_attr__('Choose Image','massive-dynamic'),
                'classicMode' => esc_attr__('Classic Mode','massive-dynamic'),
                'backendEditor' => esc_attr__('Backend Editor','massive-dynamic'),
                'yourStyle' => esc_attr__('Your Style','massive-dynamic'),
                'supportForum' => esc_attr__('Support Forum','massive-dynamic'),
                'massiveBuilder' => esc_attr__('Massive Builder','massive-dynamic'),
                'portfolioPostLayout' => esc_attr__('PORTFOLIO POST LAYOUT','massive-dynamic'),
                'welcomeMsg' => wp_kses( __('Welcome to layout builder, you have no content yet! please choose <br> a predefined layout or create your own layout for this post :)','massive-dynamic'),array('br'=>array())),
                'split' => esc_attr__('Split','massive-dynamic'),
                'fullwidth' => esc_attr__('Fullwidth','massive-dynamic'),
                'center' => esc_attr__('Center','massive-dynamic'),
                'fancy' => esc_attr__('Fancy','massive-dynamic'),
                'changeLayout' => esc_attr__('Change Layout','massive-dynamic'),
                'changeLayoutMsg' => esc_attr__("If you change this layout, you will lose this portfolio's contents. Continue?",'massive-dynamic'),
                'createWeb' => esc_attr__('Create Website With','massive-dynamic'),
                'massiveBuilderMsg' => esc_attr__('A live website builder with simple drag & drop ability, It gives you the power to make changes and see the result instantly & create a whole website in minutes!','massive-dynamic'),
                'videoMsg' => esc_attr__('To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video','massive-dynamic'),
                'updateErr' => esc_attr__("There was an issue with updating the live preview. Make sure that you click Save to ensure your changes aren't lost.",'massive-dynamic'),
                'selectImage' => esc_attr__('Select Images','massive-dynamic'),
                'blankPage' => esc_attr__('Blank Page!','massive-dynamic'),
                'dragShortcode' => wp_kses( __('Drag your shortcodes here and start<br>building your website','massive-dynamic'),array('br'=>array())),
                'chooseShortcode' => wp_kses( __('Choose a shortcode and start<br>building your website','massive-dynamic'),array('br'=>array())),
                'editSelection' => esc_attr__('Edit Selection','massive-dynamic'),
                'areYouSure' => esc_attr__('Are you sure?!','massive-dynamic'),
                'deleteMsg' => esc_attr__('Do you really want to delete this element?','massive-dynamic'),
                'deleteMsgYes' => esc_attr__('Yes Delete It!','massive-dynamic'),
                'deleteMsgNo' => esc_attr__('No Don\'t','massive-dynamic'),
            )
        );
    }
}



/**
 * Copied from Walker_Nav_Menu_Edit class in core
 * for edit fields of menu items in Appearance -> Menu
 *
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Pixflow_Walker_Nav_Menu extends Walker_Nav_Menu  {
    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     * @param int $depth
     * @param array $args
     */
    function start_lvl( &$output, $depth = 0, $args = array()) {}

    /**
     * @see Walker_Nav_Menu::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function end_lvl(&$output, $depth = 0, $args = array()) {
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        ob_start();
        $item_id =  $item->ID ;
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_attr__( '%s (Invalid)','massive-dynamic' ), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_attr__('%s (Pending)','massive-dynamic'), $item->title );
        }

        $title = empty( $item->label ) ? $title : $item->label;

        ?>
    <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo esc_attr(implode(' ', $classes )); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                        echo esc_url(wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'move-up-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                            ),
                            'move-menu_item'
                        ));
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up','massive-dynamic'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                        echo esc_url(wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'move-down-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                            ),
                            'move-menu_item'
                        ));
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down','massive-dynamic'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item','massive-dynamic'); ?>" href="<?php
                    echo esc_url(( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ));
                    ?>"><?php esc_attr_e( 'Edit Menu Item','massive-dynamic' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
                        <?php esc_attr_e( 'URL','massive-dynamic' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_url( $item->url ); ?>" />

                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">

                <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
                    <?php esc_attr_e( 'Navigation Label','massive-dynamic' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>
            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
                    <?php esc_attr_e( 'Title Attribute' ,'massive-dynamic'); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>
            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                    <?php esc_attr_e( 'Open link in a new window/tab','massive-dynamic' ); ?>
                </label>
            </p>
            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
                    <?php esc_attr_e( 'CSS Classes (optional)','massive-dynamic' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
                    <?php esc_attr_e( 'Link Relationship (XFN)','massive-dynamic' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
                    <?php esc_attr_e( 'Description','massive-dynamic' ); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php esc_attr_e('The description will be displayed in the menu if the current theme supports it.','massive-dynamic'); ?></span>
                </label>
            </p>
            <?php
            /*
             * Icon and mega menu option
             */
            ?>

            <p class="field-show-icon description description-wide">
                <span class="opts-title">Extra Menu Options</span>
                <label class="px-show-icon">
                    <?php esc_attr_e('show Icon','massive-dynamic');  ?>
                    <input type="checkbox" id="edit-menu-item-show_icon-<?php echo esc_attr($item_id); ?>" class="widefat code " name="menu-item-show_icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->show_icon ); ?>" <?php if(esc_attr( $item->show_icon )) echo "checked"; ?>>
                </label>
            </p>

            <p class="field-icon description description-wide">
                <span class="title"><?php esc_attr_e('Choose Icon:','massive-dynamic');?> </span>
                <label class="px-input-icon">
                    <?php $icons = array("empty","rating","play-curve","close","shopcart2","search3","notification","Apple","Cherries","Grapes","Tomato","Peach","Brocoli","Oliver","Carrot","Garlic","Lemon","2SeatedSofa","Strawberry","Watermelon","Avocado","Pineapple","Eggplant","Pumpkin","Grains","WorkingDesk","OfficeChair","Paddle","ButcherKnife","ChefKnife","Spoon","Cutlery","Salad","MartiniGlass","Dairy","Meatballs","GlassofWater","BeerPint","Doughnut","FrostedCupcake","TeaInfuser","Teapot","BoilingStew","FryingPan","TeaCup","CoffeeCup","GroceryBag","StrippedIcecream","ConeGelato","HotDog","Hamburger","Taco","FrenchFries","Snowflake","ChristmasTree","ChristmasShopping","Decorations","GingerbreadCookie","Mittens","Cookies","OutdoorLamp","OutdoorLamp2","Toffee","Candy","Jawbreaker","Globe","CozyArmchair","CandyCane","RoomLamp","ElectricHeater","Snowman","GingerbreadHouse","StrawberryJam","Fireplace","Cross","Spider","Skull","SodaCan","Pumpkin2","WashingMachine","King","Cheddar","BarbequeFeast","AddProfiles","SuccessFile","SyncCloud","EditMail","PartyHat","SlicedPizz","Baloons","BathTub","LuckyHorseshoe","BeerKeg","JapanesseSalad","Bread","FlowerPot","Toast","HaunchofMeat","MinecraftBone","Steak","Church","EasterEggs","HotDish","LightBulb","Shrimp","Dices","KitchenGlove","FullMoon","Cards","Microwave","Owl","Fish","ChampagneGlasses","Pie","DopeMix","VacuumCleaner","ChargingBattery","DriveLicense","Rich","Time-Tracking2","Ointment","MovetoTop","MovetoBottom","Expand","Move","PiggyBank","Target","Radar","Internet","Money","CapsuledPills","Coins","Maps","Track","Favorite","Star","Like2","Health","Dislike","CloudSync","CloudDownload","CloudUpload","Cloud","Megaphone","Wi-Fi","Airdrop","ThumbsDown","ThumbsUp","Share","Calculator","Calculator2","TurnOff","Help1","Warning1","Success","Error","VolumeDown","VolumeUp","Down","CD","MusicalNote","MovieCamera","Camera","Movie","Picture2","Video2","Locked3","Profile","Users","Send","Location","Compass","Siri","ONOFFSwitch","Bluetooth","DialPad","Unlink","TrashBin","Layers","Windows","Menu","Hide","View2","Home","Search","Search2","Flag","Vector","ReadingList","Bank","Stamp","Check","TimeisMoney","Store","Cube","Football","PlasteredFoot","Settings","Iphones","Pin","Diamond","Hairpin","Fingerprint","Privacy","Iphone5","TV","iMac","LandscapeIpad","Ipad","OldiMac","GraphPresentation","ChartPresentation","Magnet","Stethoscope","FirstAIdKit","Safety","Wheelchair","PrescriptionFile","Controls3","3DCoordinates","Controls4","SelectObjectSide","Bookmark","Store2","Bookmark2","Flag2","Cashier","USBCable","Badminton","IphoneChargingCable","Clock","Marksmanship","POS","AlarmClock","BaseballBat","Brain","FaxScan","Edit","Cup","World-Wide","Tennis","World-Wide2","IceSkates","Gift","GrowingStats","DecreasingStats","Graph2","Graph3","RollerSkates","SpiralTool","GraphicTabletIntuos","SoccerBall","Volleyball","Baseball","Basketball","PieChart22","InboxFile","LeftSidebar","BandagedFoot","Settings5","Settings8","Bicycle","Down2","Up","Upload","Download","Iphone6","Up2","SpeedDial","Whistle","PingPong","Safebox","Stopwatch","InvestmentStock","Medal","SNESController","File","Checklist","OpenFolder","Binder","Chess","Darts","Fantasia","Bowling","FullWallet","Moon","OpenSign","Sunny","GasLamp","OlympicFlare","Resumee","Sunglasses","BusinessBriefcase","Sunset","Spaceship","ExoticIsland","HockeyClubs","Marshmallows","ScanBarcode","SpaceshipLaunchPad","Campfire","UFO","OutdoorCamera","UnprotectedSystem","ProtectedSystem","6Pack","ChatConversation","ChatConversation2","ChatConversation4","Stroller","Xylophone","WoodenCrate22","Yachting","XboxRemote","Turntable2","Kayaking","SegagenesisController","ShowMicrophone","21","PS2Controller","YogaBall","BasketballPanel","DocumentFolder","Playstation1","Podium","Suitcase","Triangle","CalendarEvent","GameboyAdvance","Whatsapp","BasketballJersey","Plane","PriceTag","Tricycle","HikingBackpack","BathDuckling","Pacifier","PriceTag2","FootballJersey","GypsyTambourine","Cruise","MoneySuitcase","OutdoorStove","Briefcase","PhoneEncryption","PS4","SearchFIle","SummerRain","SwissArmyKnife","Mountainside","Suitcase2","ExpandWindow2","MildlyRottenPremolar","Nintendo64","RetrieveCard","ToyTrain","AntivirusProtection","FlipboardDocument","FootballJersey2","GypsyTambourine2","InsertCard2","Neptune","Cruise2","Flipboard2","OutdoorStove2","PS42","Saturn","SoccerJersey","Diapazone","SearchFIle2","BoyBodywear","Homer","TeddyBear","CattleSkull","ShoppingCart","Soyuz","ToyRobot","Umbrella","Chat2","Newspaper","Saxophone","Compass2","FireExtinguisher","TheOlympics","Gagarin","ChariotWheel","Blueprint","PriceTag7","SafetyPinclosed","Trombone","BoxingGlove","LogCutting","Ukulele","Skateboard","SolarSystem","SurvivalKnife","Left","Right2","BassGuitar","Luggage","Microphone","SurvivalWatch","Compose2","ElectricGuitar","Lightning","MeteoriteImpact","RotateLandscape","Stopwatch2","Earth3","Mailbox","Capitalize","FishingVest","Key","PingPong2","Binoculars","CowboyHat","Popcorn","SETIDish","WiredPhone","Cimbalom","TakeNotes","SandCastle","Bullets","ShoppingCart3","FlipFlops","Jobs","MoonLander","CommercialSatellite","Ruler","Warning","AddCartContents","Canoe","DrumSet","NativeAmericanBow","Parasailing","Feeder","MailContents","OpenMail","Bills","Sunbed","NeilArmstrong","WindToy","ColtRevolver","Tomahawk","WaterJumping","Mail","Pencial","PhoneMessage","Headphones","Quaver","ReMusicalNote","MusicalNote2","Code","ColorBucket","Forest","Briefcase2","CardioBike","ColorSpray","Ipod","DivingGear","Ruler2","Mountainside3","NativeAmericanTent","Brush","Weight","Trees","Cabin","Code2","ColorPallette","CrossroadsSigns","ColorEyedropper","HuntingLodge","facebook4","twitter-old","share","feed4","bird","chat3","phone4","phone5","monitor","laptop2","modem","hdd","keyboard","mouse","floppy","camera5","pictures2","eye4","camera6","volume","radio","cassette","broadcast2","cog3","search2","zoomout3","zoomin3","binocular","location2","pin2","quote4","clipboard","clipboard2","gift","settings2","support","medicine","cone","info","drink2","lollipop","heart2","lightning3","gaspump","tree","leaf","flower","direction","thumbsup","thumbsdown","arrow-up3","arrow-down3","arrow-left3","arrow-right3","arrow-top-right","arrow-top-left","arrow-bottom-right","arrow-bottom-left","tv2","trashcan","umbrella","printer","laptop","desktop","tablet","phone2","mobile","camera2","profile-male","profile-female","layers3","basket","envelope","twitter4","rss","tumblr3","linkedin2","cancel3","checkmark2","cancel5","checkmark4","heart3","cloud3","star","trash","search","bubble","like","world","settings","pen","diamond","location","paperplane","params","banknote","study","lab","number","number2","number3","number4","number5","number6","number7","number8","number9","number10","quote2","quote3","th-small","th-menu","th-list","th-large","leaf2","feather","plane-outline","microphone-outline","chevron-right2","chevron-left2","arrow-right-thick","arrow-left-thick","arrow-up-thick","arrow-down-thick","minus5","plus7","backspace","eye3","paper-clip","mail","toggle","layout","link2","bell","lock","unlock","ribbon","image","signal","target","clipboard3","clock","watch","air-play","camera4","video","printer2","monitor2","server","cog4","heart4","paragraph","align-justify2","align-left","align-center","align-right","book","layers4","stack","stack-2","paper","paper-stack","search4","zoom-in","zoom-out","reply","circle-plus","circle-minus","circle-check","circle-cross","square-plus","square-minus","square-check","square-cross","microphone","record2","skip-back","rewind","play2","pause2","stop2","fast-forward","skip-forward","shuffle","repeat","folder","umbrella2","moon2","thermometer2","drop","sun4","cloud4","cloud-upload","cloud-download","upload","download","location3","location-2","map","battery","head","briefcase","speech-bubble","anchor","globe","box","reload","share3","marquee","marquee-plus","marquee-minus","tag","power","command","alt","esc","bar-graph","bar-graph-2","pie-graph","star2","arrow-left4","arrow-right7","arrow-up4","arrow-down4","volume2","mute","content-right","content-left","grid2","grid-2","columns","loader","bag","ban","flag","trash2","expand","contract","maximize","minimize","plus5","minus6","check","cross","move","delete","menu3","archive","inbox","outbox","file","file-add","file-subtract","help","open","ellipsis","basecamp","behance","creative-cloud","dropbox","evernote","flattr","foursquare","google-drive","google-hangouts","grooveshark","icloud","mixi","onedrive","paypal","picasa","qq","rdio-with-circle","renren","scribd","sina-weibo","slideshare","smashing","spotify","swarm","vine","vk","xing","yelp","facebook","google","instagram","lastfm","linkedin","tumblr","play","pause","record","stop","next","previous","first","last","github6","flickr5","twitter5","facebook5","googleplus6","pinterest3","qq2","instagram2","evernote2","renren2","sina-weibo2","paypal4","picasa2","soundcloud3","mixi2","circles","vk2","smashing2","stumbleupon3","lastfm3","earth2","heart32","arrow-right4","arrow-left5","arrow-down5","arrow-up5","arrow-right5","arrow-left6","arrow-down6","arrow-up6","uniE81F","menu2","minus4","plus6","list","arrow-left7","arrow-down7","arrow-up7","arrow-right6","ccw","cw","box2","write","clock2","reply2","reply-all","forward","search22","trash22","envelope2","bubble2","user2","users","cloud23","download2","upload2","rain","sun23","moon22","bell2","folder2","pin","sound","microphone2","camera22","image2","calendar","map-marker","store","support2","tag2","heart22","video-camera","trophy","cart2","eye22","cancel4","chart","target2","printer22","location22","bookmark3","monitor22","cross2","plus22","left2","up2","browser","windows2","switch2","dashboard","play22","fast-forward2","next2","refresh","film","home2","home","pencil","quill","droplet","camera","credit-card","lifebuoy","phone","address-book","undo","redo","user","quotes-left","quotes-right","fire","airplane","switch","power-cord","cloud","link","attachment","eye","bookmark","sun","heart","loop2","share2","feed2","youtube3","twitch","vimeo","wordpress","joomla","tux","apple","finder","windows8","stackoverflow","html5","codepen","chrome","firefox","IE","opera","safari","comment","check-alt","x-altx-alt","plus-alt","plus2","document-alt-stroke","eye2","camera3","left-quote-alt","right-quote-alt","sunrise","sun2","moon","sun22","windy","wind","snowflake","cloudy","cloud2","windy2","snowy","snowy2","snowy3","weather","cloudy2","cloud22","lightning","sun3","snowy4","weather2","cloudy3","lightning2","thermometer","compass","none","Celsius","Fahrenheit","weather3","weather4","weather5","uniF488","uniF489","uniF48A","uniF48B","down","downleft","downright","up","upleft","upright","right","left","psbuttonx","menu","mouse2","uniF639","uniF477","uniF478","uniF479","uniF476","grid","details","thumbnails","quote","post2","layers","layers2","minus2","google2","youtube2","steam","github2","android","windows","paypal3","googleplus","google-drive2","lanyrd","flickr2","skype","reddit","lastfm2","yelp2","file-pdf","file-openoffice","file-word","facebook2","instagram3","picassa","dribbble","forrst","deviantart2","joomla2","blogger","yahoo","tux2","apple2","finder2","delicious","stumbleupon2","stackoverflow2","file-excel","file-zip","file-powerpoint","file-xml","file-css","html52","html522","css3","chrome2","at","copyright","multiply","cursor","circleadd","circledelete","circleselect","elipse","roundedrectangle","polygon","notificationdown","bookmark2","zoomin","zoomout","cmd","cart","cog2","minus3","plus4","cancel","zoomin2","zoomout2","cancel2","arrow-left2","arrow-up2","arrow-right2","arrow-down2","add-circle-1","baby-trolley","banking-donation-2","bin","chat-bubble-square-1","chat-bubble-square-smiley","chef-1","chef-hat","content-book-2","fire-extinguisher","fire-lighter","flash","folder-add","folder-check","folder-close","folder-subtract","food-chicken-drum-stick","food-icecream-2","glass-cocktail-2","graduation-hat","hand-gun","health-prescription-2","helicopter","hotel-bath-shower","id-card-1","key-hole-1","king","lock-1","lock-unlock-1","nature-plant-1","paint-brush-1","places-christ-the-redeemer","places-eiffel-tower","places-home-3","places-taj-mahal","police-officer-1","polo-shirt","quill2","rewards-banner-check","rewards-gift","ring-planet","romance-bow","romance-love-target","romance-relationship","save-water","user-add","user-chat-1","user-check","user-female","user-headphone","video-games-gameboy","video-games-pacman","vote-heart-circle-1","add-circle-12","airplane2","alien-head","android2","baby-trolley2","banking-debit-machine","banking-donation-22","banking-spendings-1","banking-spendings-3","bank-note","battery-charging-1","beaker-science","bin2","binoculars","box-2","building-6","building-10","building-barn","bus-2","business-briefcase-cash","business-whiteboard","calendar-1","camera-1","camera-live-view-off","car-2","castle-1","cc-camera-1","chat-bubble-square-smiley2","check-box","chef-12","chef-hat2","close2","cloud32","cog-box","coin-stack-1","computer-screen-1","content-book-22","couch","data-download-5","data-upload-5","devices","dna","download-computer","eco-field","file-new-1","file-new-2","file-notes-document","file-notes-new","file-office-text","file-tasks-add","file-zipped-new","fire-extinguisher2","flash2","folder-add2","folder-check2","folder-close2","folder-subtract2","food-chicken-drum-stick2","food-double-burger","food-icecream-22","glass-cocktail-22","graduation-hat2","hand-gun2","hand-remote","hat-magician","health-ambulance","health-graph-1","health-heart-pulse","health-hospital-sign-1","health-medicine-bottle","health-prescription-22","helicopter2","hot-air-balloon","hotel-bath-shower2","hotel-bed-1","hotel-shower","hourglass","id-card-12","inbox2","keyboard2","key-hole-12","kitchen-blender","lamp-1","lamp-studio-1","leisure-dj-booth","leisure-rest","location-gps-on-2","location-map-1","location-pin-4","location-pin-check-2","location-user","lock-12","lock-unlock-12","login-check","login-lock","login-wrong","mail-refresh-1","match-stick","monster-truck-1","motorcycle-2","music-note-1","nature-flower-1","nature-plant-12","navigation-before-1","navigation-next-1","network-business","origami-paper-bird","paint-brush-12","paper-pin","paperplane2","pencil-2","pencil-ruler","places-christ-the-redeemer2","places-colosseum","places-eiffel-tower2","places-home-32","places-home-4","places-taj-mahal2","places-warehouse-1","police-officer-12","polo-shirt2","quill22","rechargable-battery","remove-circle-1","rewards-banner-check2","rewards-gift2","rewards-medal-1","rewards-pedestal","rewards-trophy-5","ring-planet2","romance-bow2","romance-love-target2","romance-relationship2","safe","scissors","settings-1","share-megaphone-2","share-radar","share-signal-user","shopping-basket-1","shopping-basket-2","shopping-basket-add","shopping-basket-check","shopping-basket-close","shopping-basket-subtract","sign-toilet","smart-watch-circle-navigation","smiley-dolar","smiley-poker-face","smiley-shy-1","smiley-smile-2","smiley-wink","smiley-worry","spa-lotion","spa-lotus-flower","sport-basketball","sport-bowling","sport-dumbbell-1","sport-football-field","sport-takraw","spray-bottle","star-constellation","subtract-circle-1","sunny","synchronize-1","synchronize-2","tank","temple-2","toilet-roll","travel-beach","travel-camping","travel-globe","umbrella-open","undershirt","underwear","user-add2","user-chat-12","user-check2","user-headphone2","user-heart","user-male","user-subtract","vector-circle","vector-line","vector-square-1","vector-triangle","video-call-1","video-call-mobile-phone","video-camera-3","video-clip-3","video-clip-4","video-control-play","video-games-gameboy2","video-games-pacman2","vote-heart-circle-12","vote-plus-one","vote-thumbs-down","vote-thumbs-up","wallet","warehouse-box","water-droplet","water-tap","water-tower","wind-flag","window","window-programming","airplane22","alien-head2","android22","shopcart","gathermenu","chevron-right","flag2","align-justify","cog","remove","chevron-left","minus","plus","resize-vertical","resize-horizontal","chevron-up","chevron-down","arrow-left","arrow-right","arrow-up","arrow-down","angle-left","angle-right","angle-up","angle-down","caret-left","caret-up","caret-down","caret-right","sort-down","sort-up");
                    foreach($icons as $icon){ ?>
                        <span class="px-icon icon-<?php echo esc_attr($icon) ?>" data-name="<?php echo esc_attr($icon) ?>"></span>
                    <?php }
                    ?>
                    <input type="hidden" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-mega-opt" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->icon ); ?>"/>
                </label>
            </p>

            <div class="field-mega-menu description description-wide">
                <?php esc_attr_e('Mega Menu','massive-dynamic');  ?>
                <input type="checkbox" id="edit-menu-item-megaOpt-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-mega-opt" name="menu-item-megaOpt[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->megaOpt ); ?>" <?php if(esc_attr( $item->megaOpt )) echo "checked"; ?>>
            <div class="field-mega-menu-bg">
                <table>
                    <tr>
                        <td>
                            <input type="file" name="menu-item-megaBg-<?php echo esc_attr($item_id); ?>" id="menu-item-megaBg-<?php echo esc_attr($item_id); ?>"  multiple="false" accept="image/*" />
                            <?php wp_nonce_field( 'menu-item-megaBg-'.$item_id, "menu_item_megaBg_nonce_".$item_id );
                            $media = get_attached_media('image', $item_id);
                            if($media){
                            foreach($media as $m) {
                                $m=$m;
                            }
                            $imageSrc = wp_get_attachment_url($m->ID);
                            $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER_BLANK:$imageSrc;
                            ?>
                            <img id="image-<?php echo esc_attr($item_id); ?>" style="vertical-align: middle" src="<?php echo esc_url($imageSrc); ?>" width="50" height="50" />
                            <a class="icon-close remove-megaMenu-attachment" id="attachment-<?php echo esc_attr($item_id); ?>"></a>
                            <input type="hidden" name="input-attachment-<?php echo esc_attr($item_id); ?>" id="input-attachment-<?php echo esc_attr($item_id); ?>" value="0" />
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>

                            <?php esc_attr_e('Background Align','massive-dynamic');  ?>
                            <select id="edit-menu-item-megaAlign-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-mega-align" name="menu-item-megaAlign[<?php echo esc_attr($item_id); ?>]">
                                <option <?php selected( esc_attr( $item->megaAlign ), 'center center' );?> value="center center">Center Center</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'center top' );?> value="center top">Center Top</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'center bottom' );?> value="center bottom">Center Bottom</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'right top' );?> value="right top">Right Top</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'right center' );?> value="right center">Right Center</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'right bottom' );?> value="right bottom">Right Bottom</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'left top' );?> value="left top">Left Top</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'left center' );?> value="left center">Left Center</option>
                                <option <?php selected( esc_attr( $item->megaAlign ), 'left bottom' );?> value="left bottom">Left Bottom</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

            <?php
            /*
             * end added field
             */
            ?>
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( esc_attr__('Original: %s','massive-dynamic'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
                echo esc_url(wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                )); ?>"><?php esc_attr_e('Remove','massive-dynamic'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php _e('Cancel','massive-dynamic'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
        <?php
        $output .= ob_get_clean();
    }
}


class PixflowCustomNavWalker extends Walker_Nav_Menu
{
    private $navIdPrefix = '';
    private $style='';

    public function __construct($idPrefix='menu-item-')
    {
        $this->navIdPrefix = $idPrefix;
    }

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $dorpdownClass = pixflow_get_theme_mod('drop_down_style',PIXFLOW_DROP_DOWN_STYLE);
        if($depth==0){
            $style='style="'.$this->style.'"';
        }else{
            $style='';
        }

        $output .= "\n$indent<ul class=\"dropdown $dorpdownClass \" >\n";
        $output .= "\n<div class=\" megamenu-dropdown-overlay \"></div>\n";
        $output .= "\n<div class=\" megamenu-image-overlay \"  $style ></div>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $object->classes ) ? array() : (array) $object->classes;


        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );

        //add MegaMenu classes to li if li has children
        $sideModern =  (
            (pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION) == 'left' || pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION) == 'right')
            && pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME)=='modern'
        ) ? true : false;

        if (strpos($class_names,'has-children')){
            if($object->megaOpt != "" && !$sideModern && $args->theme_location != 'mobile-nav' ){
                $class_names .=" megamenu has-children has-dropdown ";
                $media = get_attached_media('image', $object->ID);
                if($media){
                    foreach($media as $m) {
                        $m=$m;
                    }
                    $imageSrc = wp_get_attachment_url($m->ID);
                    $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER_BLANK:$imageSrc;
                    $this->style="background: url(".esc_url($imageSrc).") ".$object->megaAlign." no-repeat";

                }
            }else{
                $class_names.=" has-children has-dropdown";
                $this->style="";
            }
        }

        if (pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION) == 'top' && pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME)=='modern' && $depth == 0 ) {
            $class_names .= ' btn btn-1 btn-1b ';
        }

        $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="'. $this->navIdPrefix . $object->ID . '"' . $class_names .'>';

        $href = esc_attr( $object->url);

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . $href .'"' : '';

        if($depth != 0)
        {
            $description = $prepend = '';
        }

        //If navigation location is empty $args will be an array
        if(is_array($args))
        {
            //Quick fix on getting a url for link element
            $attributes .= ! empty( $object->guid )  ? ' href="' . esc_attr( $object->guid ) .'"' : '';

            $item_output  = $args['before'];
            $item_output .= '<a'. $attributes .'><span class="menu-separator-block"></span>';
        }
        elseif (is_object($args))
        {
            $item_output  = $args->before;
            $item_output .= '<a'. $attributes .'><span class="menu-separator-block"></span>';
        }

        // Insert icon in html if user choose an icon
        $menu_item_styleDefault = ('block' == pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) && 'top' == pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION))?'icon-text':'text';
        $menu_item_style = pixflow_get_theme_mod('menu_item_style', $menu_item_styleDefault);
        $iconValue = $menu_item_style;
        $icon = true;

        //html structure for block and modern hover effect
        if ('block' == pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) && 'top' == pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION) && $depth == 0 ){
            $item_output .= '<span class="hover-effect">';
            if ( isset( $object->icon ) && $object->icon != '' && $icon ) {
                $item_output .= '<span class="icon icon-'.$object->icon.'"></span>';
            }
            $item_output .= '<span class="title">' .$object->title .'</span></span>';
        }

        $item_output .= '<span class="menu-title">';




        if ( isset( $object->icon )  && $object->icon != '' && $object->show_icon && $icon  ) {
            $item_output .= ' <span class="icon icon-'. $object->icon .'"></span>';
        };

        $item_output .= '<span class="title">' . $object->title . '</span>';

        $item_output.= '</span>';

        //if menu item wasn't first level menu item we don't want it :(;
        if( !$depth )
            $item_output .= '<span class="menu-separator"></span>';

        $item_output .= '</a>';


        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
    }

    /**
     * Ends the list of after the elements are added.
     * @see Walker::end_lvl()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( ( $depth == 1 || $depth == 2 ) && $item->megaOpt ) {
            $output .= '';
        } else {
            $output .= '</li>';

            /*  Check the style of classic menu
                set the separator according to related style
                add separator for slash,dot and dash style
             */

            if('classic' == pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) && 'top' == pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION) && $depth == 0){
                $output .= '<li class="separator" >&nbsp;';
                $output .= '<a >&nbsp;</a>';
                $output .= '</li>';
            }
        }
    }
}