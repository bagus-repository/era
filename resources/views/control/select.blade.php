<?php
if (!isset($required)) {
    $required = 0;
}
if (!isset($name)) {
    $name = '';
}
if (!isset($select_value)) {
    $select_value = 'N/A';
    $select_array = ['N/A'];
}else{
    if (is_array($select_value)) {
        $select_array = $select_value;
    }else{
        $select_array = [$select_value];
    }
}
if (!isset($onchange)) {
    $onchange = '';
} else if ($onchange == 1) {
    $onchange = 'this.form.submit()';
}
if (!isset($all)) {
    $all = '';
}
if (!isset($allvalue)) {
    $allvalue = 0;
}

if (!isset($all_text)) {
    $all_text = "All";
}

if (!isset($class)) {
    $class = "";
}

if (!isset($id)) {
    $id = '';
}

if (!isset($disabled)) {
    $disabled = '0';
}

if (!isset($placeholder)) {
    $placeholder = 0;
}

if (!isset($css)) {
    $css = '';
}

if (!isset($optVal)) {
    $optVal = 'LookupValue';
}

if (!isset($optDesc)) {
    $optDesc = 'LookupDesc';
}

if (!isset($optDescSeparator)) {
    $optDescSeparator = '-';
}

if (!isset($multiple)) {
    $multiple = 0;
}

?>

<select name="<?php echo "$name" ?>" <?php if($id != '') { ?> id="{{$id}}" <?php } ?> class="<?php echo "$class" ?>" <?php if ($onchange != '') { ?> onchange="<?php echo "$onchange" ?>" <?php } ?> <?php echo($required == 1 ? 'required':'') ?> style="<?php echo $css; ?>" {{ $disabled != '0' && $disabled != '' ? 'disabled':'' }} @if($multiple == 1) multiple @endif>
    <?php
    if ($all != '') {
        ?>
        <option value="<?php echo "$allvalue" ?>" <?php if ($select_value == $allvalue) { ?> selected="selected" <?php } ?>><?php echo "$all_text" ?></option>
    <?php
    }
    ?>
    <?php
        if ($placeholder == 1) {
            echo '<option>Pilih Opsi</option>';
        }
    ?>
    <?php
    foreach ($arr_list as $list) {
        if (is_object($list)) {
            if (is_array($optDesc)) {
                $desc = [];
                foreach ($optDesc as $item) {
                    $desc[] = $list->{$item};
                }
                $desc = implode($optDescSeparator, $desc);
            }else{
                $desc = $list->{$optDesc};
            }
            $LookupDesc = $desc;
            $LookupValue = $list->{$optVal};
            if (in_array($LookupValue, $select_array)) {
                ?>
                <option value="<?php echo "$LookupValue" ?>" selected="selected"><?php echo "$LookupDesc" ?></option>
            <?php
                } else {
                    ?>
                <option value="<?php echo "$LookupValue" ?>"><?php echo "$LookupDesc" ?></option>
        <?php
            }
        } else {
            if(in_array($list, $select_array)){
                echo "<option value='$list' selected='selected'>$list</option>";
            }else{
                echo "<option value='$list'>$list</option>";
            }
        }
        
    }
    ?>
</select>