# generate the tags
echo generate the tags
php ~/cake/console/cake.php -app ~/CakeRRGWorkspace/cakerrg/app generate_commissions_reports_tags
# tag commissions/notes items
echo commissions/notes items
php ~/cake/console/cake.php -app ~/CakeRRGWorkspace/cakerrg/app commissions_items_fix_reports_tags
# generate the reports
echo generate the reports
php ~/cake/console/cake.php -app ~/CakeRRGWorkspace/cakerrg/app generate_tag_reports
