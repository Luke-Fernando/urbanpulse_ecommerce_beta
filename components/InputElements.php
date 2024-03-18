<?php
function floatingInput($inputWidth, $inputHeight, $fontSize, $labelName, $inputId, $type, $inputValue)
{
?>
    <div class="relative z-0 <?php echo $inputWidth; ?> h-max">
        <input value="<?php echo $inputValue; ?>" type="<?php echo $type; ?>" id="<?php echo $inputId; ?>" class="block py-2.5 px-0 w-full 
        <?php echo $inputHeight . " " . $fontSize; ?> font-fm-poppins text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none 
        focus:outline-none focus:ring-0 peer" placeholder=" " />
        <label for="<?php echo $inputId; ?>" class="absolute <?php echo $fontSize; ?> text-gray-500 duration-200 transform -translate-y-6 scale-75 top-3 z-10 
    origin-[0] peer-focus:left-0 peer-focus:text-[var(--input-border-high)] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
    peer-focus:scale-75 peer-focus:-translate-y-6 capitalize font-fm-poppins pointer-events-none"><?php echo $labelName; ?></label>
    </div>
<?php
}
?>

<?php
function defaultInput($inputWidth, $inputHeight, $fontSize, $labelName, $inputId, $type, $inputValue)
{
?>
    <div class="<?php echo $inputWidth; ?> h-auto">
        <label for="<?php echo $inputId; ?>" class="block mb-2 capitalize font-fm-inter <?php echo $fontSize; ?> font-medium text-gray-900"><?php echo $labelName; ?></label>
        <input type="<?php echo $type; ?>" id="<?php echo $inputId; ?>" value="<?php echo $inputValue; ?>" class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full font-fm-inter <?php echo $inputHeight; ?> p-2.5 <?php echo $fontSize; ?>">
    </div>
<?php
}
?>

<?php
function defaultTextarea($inputWidth, $fontSize, $labelName, $inputId,  $inputValue)
{
?>
    <div class="<?php echo $inputWidth; ?> h-auto">
        <label for="<?php echo $inputId; ?>" class="block mb-2 font-fm-inter capitalize font-medium text-gray-900 <?php echo $fontSize; ?>"><?php echo $labelName; ?></label>
        <textarea id="<?php echo $inputId; ?>" rows="4" class="block p-2.5 font-fm-inter w-full <?php echo $fontSize; ?> text-gray-900 bg-gray-50 
        rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>
<?php
}
?>