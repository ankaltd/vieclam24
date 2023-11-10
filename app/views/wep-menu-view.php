<?php

/** 
 * Class for one Menu View
 */

class WEP_Menu_View {

    // Render Menu TabNav
    public static function render_menu_tab_nav($atts) {
        $stt = 0;
        foreach ($atts as $id => $item) :
            $stt++;
?>
            <li class="nav-item">
                <a class="nav-link <?php echo $stt == 1 ? 'active' : ''; ?>" id="tab-<?php echo $id ?>" data-bs-toggle="tab" aria-selected="true" role="tab" href="#content-<?php echo $id ?>">
                    <span class="icon">
                        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="18" height="23" viewBox="0 0 18 23">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                        stroke: #3a3a3a;
                                        stroke-miterlimit: 5.25;
                                        stroke-width: 1.31px;
                                    }

                                    .cls-2 {
                                        fill: #3a3a3a;
                                    }
                                </style>
                            </defs>
                            <rect class="cls-1" x="3.09" y="1.7" width="11.81" height="19.69" rx="1.97" />
                            <circle class="cls-2" cx="9" cy="18.11" r="1.31" />
                        </svg>
                    </span>
                    <span class="text"><?php echo $item['title']; ?></span>
                </a>
            </li>
        <?php
        endforeach;
    }

    // Render Menu TabContent
    public static function render_menu_tab_content($atts) {
        $stt = 0;
        foreach ($atts as $id => $item) :
            $sub_empty = empty($item['sub_menu']);
            $stt++;
        ?>
            <!-- Các tab content -->
            <div class="tab-pane fade <?php echo $stt == 1 ? 'active show' : ''; ?>" id="content-<?php echo $id ?>">
                <?php
                if ($sub_empty) :
                ?>
                    <p class="main_menu_item__link"><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></p>
                <?php
                else :
                ?>
                    <div class="wep_content_wrapper">
                        <h5 class="main_menu_item__title"><strong><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></strong></h5>
                        <ul class="sub_menu_list">
                            <?php
                            foreach ($item['sub_menu'] as $id2 => $item2) :
                                $sub_empty2 = empty($item['sub_menu']);
                                echo '<li class="sub_menu_item">';
                            ?>
                                <a href="<?php echo $item2['link']; ?>"><?php echo $item2['title']; ?></a>
                                <?php if (!$sub_empty2) :
                                    echo '<ul class="sub_menu_list level_2">';
                                    foreach ($item2['sub_menu'] as $id3 => $item3) :
                                        echo '<li class="sub_menu_item level_2">';
                                ?>
                                        <a href="<?php echo $item3['link']; ?>"><?php echo $item3['title']; ?></a>
                                <?php
                                        echo '</li>'; // end of sub_menu_item level_2
                                    endforeach;
                                    echo '</ul'; // end of sub_menu_list level_2
                                endif;
                                echo '</li>'; // end of sub_menu_item
                                ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
<?php
        endforeach;
    }

    // Render Menu Multi level
    public static function render_menu($atts, $is_sub_menu = false, $init_classes = 'navbar-nav justify-content-start align-content-center flex-grow-1 pe-3 d-none d-md-flex', $is_sub_image = false, $sub_level = 0) {

        $sub_image_classes = $is_sub_image ? 'sub_image' : '';
        $sub_level++;

        if ($is_sub_menu) {
            echo '<ul class="dropdown-menu dropdown-mega ' . $sub_image_classes . ' level_' . $sub_level . '">';
        } else {
            echo '<ul class="' . $init_classes . '">';
        }

        foreach ($atts as $label => $item) {

            if ($is_sub_menu) {
                echo '<li>';
            } else {
                echo '<li class="nav-item dropdown">';
            }

            // check render text or image
            $sub_image = isset($item['sub_image']) ? $item['sub_image'] : false;
            $icon_arrow_html = '<span class="icon_arrow"><span class="icon_arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span>';

            if (is_array($item)) {
                echo '<a class="nav-link" href="' . esc_url($item['link']) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false" target="_blank">' . esc_html($label) . '</a>';
                self::render_menu($item['sub_menu'], true, '', $sub_image, $sub_level); // Đệ quy cho submenu
            } else {
                $item_html = '';
                if ($is_sub_menu) {
                    if (isset($item['current']) && $item['current']) {
                        $item_html = sprintf('<a class="dropdown-item active" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="dropdown-item active" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    } else {
                        $item_html = sprintf('<a class="dropdown-item" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="dropdown-item" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    }
                } else {
                    if (isset($item['current']) && $item['current']) {
                        $item_html = sprintf('<a class="nav-link active" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="nav-link active" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    } else {
                        $item_html = sprintf('<a class="nav-link" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="nav-link" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    }
                }
                echo $item_html;
            }
            echo '</li>';
        }

        if ($is_sub_menu) {
            echo '</ul>';
        }
    }

    // Render Mega Menu
    public static function render_menu_mega($atts, $is_sub_menu = false, $init_classes = 'navbar-nav justify-content-start align-content-center flex-grow-1 pe-3 d-none d-md-flex', $is_sub_image = false, $sub_level = 0) {

        $sub_image_classes = $is_sub_image ? 'sub_image' : '';
        $sub_level++;

        if ($is_sub_menu) {
            echo '<ul class="dropdown-menu dropdown-mega ' . $sub_image_classes . ' level_' . $sub_level . '">';
        } else {
            echo '<ul class="' . $init_classes . '">';
        }

        foreach ($atts as $label => $item) {

            if ($is_sub_menu) {
                echo '<li>';
            } else {
                echo '<li class="nav-item dropdown">';
            }

            // check render text or image
            $sub_image = isset($item['sub_image']) ? $item['sub_image'] : false;
            $icon_arrow_html = '<span class="icon_arrow"><span class="icon_arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span>';

            if (is_array($item)) {
                echo '<a class="nav-link" href="' . esc_url($item['link']) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false" target="_blank">' . esc_html($label) . '</a>';
                self::render_menu_mega($item['sub_menu'], true, '', $sub_image, $sub_level); // Đệ quy cho submenu
            } else {
                $item_html = '';
                if ($is_sub_menu) {
                    if (isset($item['current']) && $item['current']) {
                        $item_html = sprintf('<a class="dropdown-item active" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="dropdown-item active" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    } else {
                        $item_html = sprintf('<a class="dropdown-item" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="dropdown-item" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    }
                } else {
                    if (isset($item['current']) && $item['current']) {
                        $item_html = sprintf('<a class="nav-link active" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="nav-link active" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    } else {
                        $item_html = sprintf('<a class="nav-link" href="%s">%s</a>', esc_url($item), esc_html($label));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="nav-link" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item), esc_html($label));
                        }
                    }
                }
                echo $item_html;
            }
            echo '</li>';
        }

        if ($is_sub_menu) {
            echo '</ul>';
        }
    }

    // Render Mega Menu 2
    public static function render_menu_mega2($atts, $is_sub_menu = false, $init_classes = 'navbar-nav justify-content-start align-content-center flex-grow-1 pe-3 d-none d-md-flex', $is_sub_image = false, $sub_level = 0) {

        $sub_image_classes = $is_sub_image ? 'sub_image' : '';
        $sub_level++;

        if ($is_sub_menu) {
            echo '<ul class="dropdown-menu dropdown-mega ' . $sub_image_classes . ' level_' . $sub_level . '">';
        } else {
            echo '<ul class="' . $init_classes . '">';
        }

        foreach ($atts as $key => $item) {

            if ($is_sub_menu) {
                echo '<li>';
            } else {
                echo '<li class="nav-item dropdown">';
            }

            // check render text or image
            $sub_image = isset($item['sub_image']) ? $item['sub_image'] : false;
            $icon_arrow_html = '<span class="icon_arrow"><span class="icon_arrow" style="display:flex !important"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span>';

            $sub_empty = empty($item['sub_menu']);

            if (is_array($item) && !$sub_empty) {
                echo '<a class="nav-link" href="' . esc_url($item['link']) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false" target="_blank">' . esc_html($item['title']) . $icon_arrow_html . '</a>';
                self::render_menu_mega2($item['sub_menu'], true, '', $sub_image, $sub_level); // Đệ quy cho submenu
            } else {
                $item_html = '';
                if ($is_sub_menu) {
                    if (isset($item['current']) && $item['current']) {
                        $item_html = sprintf('<a class="dropdown-item active" href="%s">%s</a>', esc_url($item['link']), esc_html($item['title']));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="dropdown-item active" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item['link']), esc_html($item['title']));
                        }
                    } else {
                        $item_html = sprintf('<a class="dropdown-item" href="%s">%s %s</a>', esc_url($item['link']), $icon_arrow_html, esc_html($item['title']));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="dropdown-item" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item['link']), esc_html($item['title']));
                        }
                    }
                } else {
                    if (isset($item['current']) && $item['current']) {
                        $item_html = sprintf('<a class="nav-link active" href="%s">%s</a>', esc_url($item['link']), esc_html($item['title']));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="nav-link active" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item['link']), esc_html($item['title']));
                        }
                    } else {
                        $item_html = sprintf('<a class="nav-link" href="%s">%s</a>', esc_url($item['link']), esc_html($item['title']));
                        if ($is_sub_image) {
                            $item_html = sprintf('<a class="nav-link" href="%s"><img src="%s" width="auto" height="20"></a>', esc_url($item['link']), esc_html($item['title']));
                        }
                    }
                }
                echo $item_html;
            }
            echo '</li>';
        }

        if ($is_sub_menu) {
            echo '</ul>';
        }
    }
}
