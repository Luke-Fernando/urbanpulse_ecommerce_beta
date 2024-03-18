 <?php


    function customSelect($inputWidth, $inputHeight, $fontSize, $selectorId, $optionsArr, $isBorder)
    {
    ?>

     <section data-selector="gender" class="<?php echo $inputWidth . " " . $inputHeight; ?> relative flex flex-col justify-center items-start cursor-default 
     <?php if ($isBorder) {
            echo "border-b-2 border-gray-300";
        } ?> bg-transparent">

         <select name="gender" id="<?php echo $selectorId ?>" class="w-full h-full border-none  focus:ring-0 capitalize font-fm-poppins 
         text-gray-500 truncate <?php echo $fontSize; ?>">
             <?php
                for ($i = 0; $i < sizeof($optionsArr); $i++) {
                ?>
                 <option value="<?php echo $optionsArr[$i]["value"]; ?>" class="transition-all duration-200 capitalize 
                 hover:bg-[var(--input-border-low)] <?php echo $fontSize; ?>" <?php
                                                                                if ($i == 0) {
                                                                                    echo ("selected");
                                                                                } ?>><?php echo $optionsArr[$i]["name"]; ?></option>
             <?php
                }
                ?>
         </select>
     </section>

 <?php
    }

    function generate_options($query, $paraArr, $firstOption, $optionNameProp, $optionValueProp)
    {
        $options = array();
        $resultset = Database::search($query, $paraArr);
        $resultset_num = $resultset->num_rows;
        for ($i = 0; $i < (intval($resultset_num) + 1); $i++) {
            if ($i == "0") {
                $optionArr = array(
                    "name" => $firstOption,
                    "value" => "0"
                );
                array_push($options, $optionArr);
            } else {
                $resultset_data = $resultset->fetch_assoc();
                $optionArr = array(
                    "name" => $resultset_data[$optionNameProp],
                    "value" => $resultset_data[$optionValueProp]
                );
                array_push($options, $optionArr);
            }
        }
        return $options;
    }
    ?>