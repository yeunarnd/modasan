<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->
</div>

<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url() ?>assets/assets/js/jquery.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo base_url() ?>assets/assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url() ?>assets/assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
</script>
<script src="<?php echo base_url() ?>assets/assets/js/bootstrap.js"></script>
<script src="http://www.rsigondanglegi.com/laris/assets/table/bootstrap-table.js"></script>

<script>
    function disable() {
        document.getElementById("name").disabled = true;
    }

    function enable() {
        document.getElementById("name").disabled = false;
    }
</script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url() ?>assets/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/ddtf.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<!-- page specific plugin scripts -->
<script src="<?php echo base_url() ?>assets/assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/jquery.ui.touch-punch.js"></script>

<!-- <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/assets/js/dataTables.editor.min"></script> -->
<!-- ace scripts -->
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.scroller.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.colorpicker.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.fileinput.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.typeahead.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.wysiwyg.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.spinner.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.treeview.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.wizard.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.aside.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.ajax-content.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.touch-drag.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.sidebar.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.sidebar-scroll-1.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.submenu-hover.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.widget-box.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.settings.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.settings-rtl.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.settings-skin.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.widget-on-reload.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.searchbox-autocomplete.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($) {
        var $sidebar = $('.sidebar').eq(0);
        if (!$sidebar.hasClass('h-sidebar')) return;

        $(document).on('settings.ace.top_menu', function(ev, event_name, fixed) {
            if (event_name !== 'sidebar_fixed') return;

            var sidebar = $sidebar.get(0);
            var $window = $(window);

            //return if sidebar is not fixed or in mobile view mode
            var sidebar_vars = $sidebar.ace_sidebar('vars');
            if (!fixed || (sidebar_vars['mobile_view'] || sidebar_vars['collapsible'])) {
                $sidebar.removeClass('lower-highlight');
                //restore original, default marginTop
                sidebar.style.marginTop = '';

                $window.off('scroll.ace.top_menu')
                return;
            }


            var done = false;
            $window.on('scroll.ace.top_menu', function(e) {

                var scroll = $window.scrollTop();
                scroll = parseInt(scroll / 4); //move the menu up 1px for every 4px of document scrolling
                if (scroll > 17) scroll = 17;


                if (scroll > 16) {
                    if (!done) {
                        $sidebar.addClass('lower-highlight');
                        done = true;
                    }
                } else {
                    if (done) {
                        $sidebar.removeClass('lower-highlight');
                        done = false;
                    }
                }

                sidebar.style['marginTop'] = (17 - scroll) + 'px';
            }).triggerHandler('scroll.ace.top_menu');

        }).triggerHandler('settings.ace.top_menu', ['sidebar_fixed', $sidebar.hasClass('sidebar-fixed')]);

        $(window).on('resize.ace.top_menu', function() {
            $(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed', $sidebar.hasClass('sidebar-fixed')]);
        });


        $(document).ready(function() {

            $('#btnSubmit').click(function() {

                $('.row-select input:checked').each(function() {
                    var id;
                    id = $(this).closest('tr').find('.id').html();
                    // name = $(this).closest('tr').find('.name').html();

                    alert('ID: ' + id);
                })

            })


            $('#btnSelectAll').click(function() {

                $('.row-select input').each(function() {
                    $(this).prop('checked', true);
                })

            })

        })

    });
</script>

<!-- the following scripts are used in demo only for onpage help and you don't need them -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/ace.onpage-help.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/docs/assets/js/themes/sunburst.css" />

<script type="text/javascript">
    ace.vars['base'] = '..';
</script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/elements.onpage-help.js"></script>
<script src="<?php echo base_url() ?>assets/assets/js/ace/ace.onpage-help.js"></script>
<script src="<?php echo base_url() ?>assets/docs/assets/js/rainbow.js"></script>
<script src="<?php echo base_url() ?>assets/docs/assets/js/language/generic.js"></script>
<script src="<?php echo base_url() ?>assets/docs/assets/js/language/html.js"></script>
<script src="<?php echo base_url() ?>assets/docs/assets/js/language/css.js"></script>
<script src="<?php echo base_url() ?>assets/docs/assets/js/language/javascript.js"></script>

</body>

</html>