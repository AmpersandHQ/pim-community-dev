({"optimize":"uglify2","preserveLicenseComments":true,"paths":{"require-config":"..\/js\/require-config","require-lib":"ororequirejs\/lib\/require"},"baseUrl":".\/bundles","out":".\/js\/oro.min.js","mainConfigFile":".\/js\/require-config.js","include":["require-config","require-lib","oro\/form\/system\/config","oro\/form\/system\/config\/system","oro\/form\/system\/config\/group\/localization","oro\/form\/system\/config\/group\/notification","oro\/form\/system\/config\/save","text!oro\/template\/system\/config","text!oro\/template\/system\/tab\/system","text!oro\/template\/system\/group\/localization","text!oro\/template\/system\/group\/notification","routing","jquery.form","url","oro\/navigation","oro\/navigation\/abstract-view","oro\/navigation\/collection","oro\/navigation\/dotmenu\/item-view","oro\/navigation\/dotmenu\/view","oro\/navigation\/favorites\/view","oro\/navigation\/model","oro\/navigation\/pinbar\/collection","oro\/navigation\/pinbar\/item-view","oro\/navigation\/pinbar\/model","oro\/navigation\/pinbar\/view","oro\/init-user","pim\/data-collector","pim\/patch-fetcher","pim\/dashboard\/abstract-widget","pim\/dashboard\/completeness-widget","pim\/dashboard\/last-operations-widget","pim\/dashboard\/widget-container","text!pim\/dashboard\/template\/completeness-widget","text!pim\/dashboard\/template\/last-operations-widget","text","json","base64","jquery","jquery-ui","jquery.numeric","jquery.select2","jquery.jstree","jstree\/jquery.hotkeys","bootstrap","underscore","backbone","backbone\/bootstrap-modal","summernote","oro\/app","oro\/error","oro\/init-layout","oro\/jquery-setup","oro\/layout","oro\/mediator","oro\/messenger","oro\/modal","oro\/delete-confirmation","oro\/tools","oro\/form\/state","jquery.slimbox","bootstrap.bootstrapswitch","bootstrap.datetimepicker","wysiwyg","datepicker","jquery.sidebarize","pim\/ui","pim\/initselect2","pim\/dialog","pim\/formupdatelistener","pim\/saveformstate","pim\/fileinput","pim\/dialogform","pim\/dropzonejs","pim\/indicator","pim\/notifications","pim\/notification-list","text!pim\/template\/notification\/notification","text!pim\/template\/notification\/notification-footer","text!pim\/template\/notification\/notification-list","oro\/datagrid\/tab-redirect-action","pim\/datagrid\/configure-columns-action","oro\/export-widget","pim\/datagrid\/state","pim\/datagrid\/state-listener","pim\/datagrid\/column-form-listener","oro\/datagrid\/action-launcher","oro\/datagrid\/abstract-action","oro\/datagrid\/delete-action","oro\/datagrid\/ajax-action","oro\/datagrid\/mass-action","oro\/datagrid\/model-action","oro\/datagrid\/navigate-action","oro\/datagrid\/refresh-collection-action","oro\/datagrid\/reset-collection-action","oro\/datagrid\/actions-panel","oro\/datagrid\/action-column","oro\/datagrid\/body","oro\/datagrid\/action-cell","oro\/datagrid\/boolean-cell","oro\/datagrid\/html-cell","oro\/datagrid\/date-cell","oro\/datagrid\/datetime-cell","oro\/datagrid\/number-cell","oro\/datagrid\/select-cell","oro\/datagrid\/select-row-cell","oro\/datagrid\/string-cell","oro\/datagrid\/cell-formatter","oro\/datagrid\/grid","oro\/datagrid\/header-cell","oro\/datagrid\/select-all-header-cell","oro\/datagrid\/header","oro\/datagrid\/abstract-listener","oro\/datagrid\/column-form-listener","oro\/datagrid\/callback-listener","oro\/datagrid\/page-size","oro\/datagrid\/grid-views\/view","oro\/datagrid\/grid-views\/model","oro\/datagrid\/grid-views\/collection","oro\/datagrid\/pagination-input","oro\/datagrid\/pagination","oro\/datagrid\/router","oro\/datagrid\/row","oro\/datagrid\/toolbar","oro\/datagrid-builder","oro\/loading-mask","oro\/pageable-collection","backbone\/pageable-collection","backgrid","jquery.multiselect","jquery.multiselect.filter","oro\/multiselect-decorator","oro\/datafilter\/price-filter","oro\/datafilter\/metric-filter","oro\/datafilter\/product_scope-filter","oro\/datafilter\/product_category-filter","oro\/datafilter\/product_completeness-filter","oro\/datafilter\/ajax-choice-filter","oro\/datafilter\/select2-choice-filter","oro\/datafilter\/select2-rest-choice-filter","oro\/datafilter\/abstract-filter","oro\/datafilter\/none-filter","oro\/datafilter\/choice-filter","oro\/datafilter\/date-filter","oro\/datafilter\/datetime-filter","oro\/datafilter\/multiselect-filter","oro\/datafilter\/number-filter","oro\/datafilter\/select-filter","oro\/datafilter\/select-row-filter","oro\/datafilter\/text-filter","oro\/datafilter\/abstract-formatter","oro\/datafilter\/filters-manager","oro\/datafilter\/collection-filters-manager","oro\/datafilter-builder","text!pim\/template\/datagrid\/action-launcher-button","text!pim\/template\/datagrid\/action-launcher-list-item","text!pim\/template\/datagrid\/actions-group","text!pim\/template\/datagrid\/configure-columns-action","text!pim\/template\/datagrid\/filter\/select2-choice-filter","text!pim\/template\/datagrid\/filter\/date-filter","pim\/job-execution-view","jquery.wizard","jstree\/jquery.jstree.tree_selector","jstree\/nested_switch","pim\/init","pim\/asynctab","pim\/popinform","pim\/optionform","pim\/form-modal","pim\/scopable","pim\/currencyfield","pim\/tree\/view","pim\/tree\/associate","pim\/tree\/manage","pim\/attributeoptionview","pim\/item\/tableview","pim\/item\/view","pim\/i18n","pim\/user-context","pim\/date-context","pim\/error","translator","oro\/translator","pim\/security-context","pim\/product-manager","pim\/variant-group-manager","pim\/group-manager","pim\/attribute-manager","pim\/attribute-group-manager","pim\/history-item-manager","pim\/fetcher-registry","pim\/base-fetcher","pim\/attribute-fetcher","pim\/completeness-fetcher","pim\/product-fetcher","pim\/variant-group-fetcher","pim\/remover\/base","pim\/remover\/product","pim\/remover\/variant-group","pim\/saver\/base","pim\/saver\/product","pim\/saver\/variant-group","pim\/media-url-generator","pim\/form-builder","pim\/form-registry","pim\/form-config-provider","pim\/cache-invalidator","pim\/form","pim\/variant-group-edit-form\/save","pim\/product-edit-form\/product-label","pim\/product-edit-form\/attributes\/validation","pim\/product-edit-form\/attributes\/validation-error","pim\/product-edit-form\/attributes\/variant-group","pim\/product-edit-form\/attributes\/locale-specific","pim\/product-edit-form\/attributes\/localizable","pim\/product-edit-form\/categories","pim\/product-edit-form\/associations","pim\/product-edit-form\/panel\/panels","pim\/product-edit-form\/panel\/selector","pim\/product-edit-form\/locale-switcher","pim\/product-edit-form\/scope-switcher","pim\/product-edit-form\/panel\/completeness","pim\/product-edit-form\/panel\/history","pim\/product-edit-form\/panel\/comments","pim\/product-edit-form\/save","pim\/product-edit-form\/save-and-back","pim\/product-edit-form\/sequential-edit","pim\/product-edit-form\/delete","pim\/product-edit-form\/meta\/family","pim\/product-edit-form\/meta\/change-family","pim\/product-edit-form\/meta\/groups","pim\/product-edit-form\/status-switcher","pim\/product-edit-form\/download-pdf","pim\/product-edit-form\/attributes","pim\/product-edit-form\/back-to-grid","pim\/export\/product\/edit\/content","pim\/export\/product\/edit\/content\/readonly","pim\/export\/product\/edit\/content\/structure","pim\/export\/product\/edit\/content\/structure\/scope","pim\/export\/product\/edit\/content\/structure\/locales","pim\/export\/product\/edit\/content\/structure\/attributes","pim\/export\/product\/edit\/content\/structure\/attributes-selector","pim\/export\/product\/edit\/content\/data","pim\/export\/product\/edit\/content\/data\/add-filter","pim\/export\/product\/edit\/content\/data\/default-attribute-filters","pim\/export\/product\/edit\/content\/data\/help","pim\/export\/product\/edit\/content\/data\/validation","pim\/filter\/filter","pim\/filter\/text","pim\/filter\/simpleselect","pim\/filter\/product\/family","pim\/filter\/product\/enabled","pim\/filter\/product\/updated","pim\/filter\/product\/completeness","pim\/filter\/product\/category","pim\/filter\/product\/category\/selector","pim\/filter\/attribute\/identifier","pim\/filter\/attribute\/attribute","pim\/filter\/attribute\/boolean","pim\/filter\/attribute\/string","pim\/filter\/attribute\/metric","pim\/filter\/attribute\/price-collection","pim\/filter\/attribute\/number","pim\/filter\/attribute\/select","pim\/filter\/attribute\/media","pim\/filter\/attribute\/date","pim\/field-manager","pim\/product-create","pim\/product-create-form","pim\/mass-product-edit-form\/hidden-field-updater","pim\/mass-product-edit-form\/attributes","pim\/attribute-option-form","pim\/attribute-option\/create","pim\/variant-group-edit-form\/properties","pim\/variant-group-edit-form\/products","pim\/variant-group-edit-form\/delete","pim\/variant-group-edit-form\/no-attribute","pim\/variant-group-edit-form\/properties\/general","pim\/variant-group-edit-form\/properties\/translation","pim\/variant-group-edit-form\/meta\/product-count","pim\/variant-group-edit-form\/add-attribute","pim\/common\/tab\/history","pim\/common\/grid","pim\/common\/add-attribute","pim\/form\/common\/edit-form","pim\/form\/common\/label","pim\/form\/common\/group-selector","pim\/form\/common\/attributes\/attribute-group-selector","pim\/form\/common\/save","pim\/form\/common\/delete","pim\/form\/common\/back-to-grid","pim\/form\/common\/form-tabs","pim\/form\/common\/save-buttons","pim\/form\/common\/state","pim\/form\/common\/meta\/created","pim\/form\/common\/meta\/updated","pim\/form\/common\/attributes","pim\/form\/common\/attributes\/copy","pim\/form\/common\/attributes\/copy-field","pim\/common\/column-list-view","pim\/common\/add-attribute-line","pim\/common\/add-attribute-footer","pim\/field","pim\/boolean-field","pim\/date-field","pim\/media-field","pim\/metric-field","pim\/multi-select-field","pim\/number-field","pim\/price-collection-field","pim\/simple-select-field","pim\/text-field","pim\/textarea-field","pim\/wysiwyg-field","pim\/formatter\/choices\/base","text!pim\/template\/form\/group-selector","text!pim\/template\/form\/save","text!pim\/template\/form\/delete","text!pim\/template\/form\/tab\/history","text!pim\/template\/form\/grid","text!pim\/template\/form\/attribute\/add-attribute","text!pim\/template\/form\/attribute\/add-attribute-line","text!pim\/template\/form\/attribute\/add-attribute-footer","text!pim\/template\/form\/back-to-grid","text!pim\/template\/form\/form-tabs","text!pim\/template\/form\/state","text!pim\/template\/form\/meta\/created","text!pim\/template\/form\/meta\/updated","text!pim\/template\/form\/tab\/attributes","text!pim\/template\/form\/save-buttons","text!pim\/template\/form\/edit-form","text!pim\/template\/form\/tab\/attribute\/attribute-group-selector","text!pim\/template\/form\/tab\/attribute\/copy","text!pim\/template\/form\/tab\/attribute\/copy-field","text!pim\/template\/product\/tab\/categories","text!pim\/template\/product\/tab\/attribute\/validation-error","text!pim\/template\/product\/tab\/attribute\/variant-group","text!pim\/template\/product\/tab\/associations","text!pim\/template\/product\/tab\/association-panes","text!pim\/template\/product\/panel\/container","text!pim\/template\/product\/panel\/selector","text!pim\/template\/product\/panel\/completeness","text!pim\/template\/product\/panel\/history","text!pim\/template\/product\/panel\/comments","text!pim\/template\/product\/locale-switcher","text!pim\/template\/product\/sequential-edit","text!pim\/template\/product\/status-switcher","text!pim\/template\/product\/download-pdf","text!pim\/template\/product\/meta\/family","text!pim\/template\/product\/meta\/change-family-modal","text!pim\/template\/product\/meta\/groups","text!pim\/template\/product\/meta\/group-modal","text!pim\/template\/product\/scope-switcher","text!pim\/template\/product\/field\/field","text!pim\/template\/product\/field\/boolean","text!pim\/template\/product\/field\/date","text!pim\/template\/product\/field\/media","text!pim\/template\/product\/field\/metric","text!pim\/template\/product\/field\/multi-select","text!pim\/template\/product\/field\/number","text!pim\/template\/product\/field\/price-collection","text!pim\/template\/product\/field\/simple-select","text!pim\/template\/product\/field\/text","text!pim\/template\/product\/field\/textarea","text!pim\/template\/product-create-popin","text!pim\/template\/attribute-option\/form","text!pim\/template\/attribute-option\/validation-error","text!pim\/template\/i18n\/flag","text!pim\/template\/error\/error","text!pim\/template\/variant-group\/tab\/properties","text!pim\/template\/variant-group\/tab\/properties\/general","text!pim\/template\/variant-group\/tab\/properties\/translation","text!pim\/template\/variant-group\/meta\/product-count","text!pim\/template\/variant-group\/form\/no-attribute","text!pim\/template\/export\/product\/edit\/content","text!pim\/template\/export\/product\/edit\/content\/data","text!pim\/template\/export\/product\/edit\/content\/data\/help","text!pim\/template\/export\/product\/edit\/content\/data\/validation","text!pim\/template\/export\/product\/edit\/content\/structure","text!pim\/template\/export\/product\/edit\/content\/structure\/scope","text!pim\/template\/export\/product\/edit\/content\/structure\/locales","text!pim\/template\/export\/product\/edit\/content\/structure\/attributes","text!pim\/template\/export\/product\/edit\/content\/structure\/attributes-selector","text!pim\/template\/export\/product\/edit\/content\/structure\/attribute-list","text!pim\/template\/filter\/filter","text!pim\/template\/filter\/text","text!pim\/template\/filter\/simpleselect","text!pim\/template\/filter\/product\/family","text!pim\/template\/filter\/product\/enabled","text!pim\/template\/filter\/product\/updated","text!pim\/template\/filter\/product\/completeness","text!pim\/template\/filter\/product\/category","text!pim\/template\/filter\/product\/category\/selector","text!pim\/template\/filter\/product\/identifier","text!pim\/template\/filter\/attribute\/boolean","text!pim\/template\/filter\/attribute\/string","text!pim\/template\/filter\/attribute\/metric","text!pim\/template\/filter\/attribute\/price-collection","text!pim\/template\/filter\/attribute\/number","text!pim\/template\/filter\/attribute\/select","text!pim\/template\/filter\/attribute\/media","text!pim\/template\/filter\/attribute\/date","pim\/reference-simple-select-field","pim\/reference-multi-select-field"]})