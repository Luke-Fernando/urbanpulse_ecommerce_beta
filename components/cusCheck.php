<?php
function customCheck($fontSize, $checkId, $checkLabel, $isChecked)
{
?>
    <section class="flex items-center">
        <div data-checkbox-container="<?php echo $checkId; ?>" class="w-max flex justify-center items-center aspect-square border border-[var(--input-border-high)] relative">
            <input data-checkbox="<?php echo $checkId; ?>" type="checkbox" id="<?php echo $checkId; ?>" class="opacity-0" <?php if ($isChecked == 1) {
                                                                                                                            ?> checked <?php
                                                                                                                                    } ?>>
            <img src="../assets/images/checkBox/checkmark.svg" class="w-full scale-100 absolute inset-0 z-10 pointer-events-none">
        </div>
        <label for="<?php echo $checkId; ?>" class="<?php echo $fontSize; ?> capitalize text-gray-900 pl-5 font-fm-poppins"><?php echo $checkLabel; ?></label>
    </section>
<?php
}
?>