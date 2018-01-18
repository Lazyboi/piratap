<?php
namespace LPU;

class Datalist
{
    /**
     * Display the data as table.
     *
     * @param array $columns
     * @param array $data
     * @param string $action
     */
    public static function displayTable($columns, $data, $action)
    {
        $table = '';
        $table .= '<table class=\'table\'>';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th class=\'text-center\'><input class=\'toggle-item-checkbox\' title=\'Click to select all items\' type=\'checkbox\'></th>';

        foreach ($columns as $header) {
            $table .= "<th>{$header}</th>";
        }

        $table .= '<th class=\'text-center\'>ACTIONS</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';

        if ($data) {
            foreach ($data as $row) {
                $table .= '<tr>';
                $table .= "<td class='text-center'><input class='item-checkbox' title='Click to select item' type='checkbox' value='{$row['id']}'></td>";

                foreach ($row as $key => $value) {
                    if (array_key_exists($key, $columns)) {
                        $table .= '<td>';
                        $table .= !empty($value) ? $value : '<div>' . Placeholder::get('short') . '</div>' ;
                        $table .= '</td>';
                    }
                }

                $table .= "<td class='text-center'>{$action($row['id'])}</td>";
                $table .= '</tr>';
            }
        } else {
            $table .= '<tr><td class=\'text-center\' colspan=\'' . (count($columns) + 2). '\'><div>' . Placeholder::get('long') . '</div></td></tr>';
        }

        $table .= '</tbody>';
        $table .= '<tfoot>';
        $table .= '<tr>';
        $table .= '<th class=\'text-center\'><input class=\'toggle-item-checkbox\' title=\'Click to select all items\' type=\'checkbox\'></th>';

        foreach ($columns as $footer) {
            $table .= "<th>{$footer}</th>";
        }

        $table .= '<th class=\'text-center\'>ACTIONS</th>';
        $table .= '</tr>';
        $table .= '</tfoot>';
        $table .= '</table>';

        echo $table;
    }

    /**
     * Display data as select box.
     *
     * @param array $columns
     * @param array $data
     * @param string || array $default_data
     */
    public static function displaySelect($columns, $data, $default_data = null)
    {
        $select = '';
        $disabled = '';
        $selected = '';

        foreach ($data as $row) {
            $disabled = !empty($row['disabled_at']) && !empty($row['disabled_by']) ? 'disabled' : '' ;

            if (!empty($default_data)) {
                $selected = is_array($default_data) ? (in_array($row['id'], $default_data) ? 'selected' : '') : ($default_data == $row['id'] ? 'selected' : '') ;
            }

            $select .= "<option value='{$row['id']}' {$disabled} {$selected}>";

            foreach ($row as $key => $value) {
                if (in_array($key, $columns)) {
                    $select .= !empty($value) ? "{$value}" : '' ;
                }
            }

            $select .= '</option>';
        }

        echo $select;
    }

    /**
     * Display the data as radio.
     *
     * @param array $columns
     * @param string $name
     * @param array $data
     * @param string || array $default_data
     * @param bool $required
     */
    public static function displayRadio($columns, $name, $data, $default_data = null, $required = false)
    {
        $checkbox = '';
        $checked = '';
        $disabled = '';

        foreach ($data as $row) {
            $disabled = !empty($row['disabled_at']) && !empty($row['disabled_by']) ? 'disabled' : '' ;

            if (!empty($default_data)) {
                $checked = is_array($default_data) ? (in_array($row['id'], $default_data) ? 'checked' : '') : ($default_data == $row['id'] ? 'checked' : '') ;
            }

            $checkbox .= '<div class=\'radio\'>';
            $checkbox .= '<label>';
            $checkbox .= "<input {$checked} {$disabled} name='{$name}' " . ($required ? 'required' : '') . " type='radio' value='{$row['id']}'>";

            foreach ($row as $key => $value) {
                if (in_array($key, $columns)) {
                    $checkbox .= !empty($value) ? "{$value}" : '' ;
                }
            }

            $checkbox .= '</label>';
            $checkbox .= '</div>';
        }

        echo $checkbox;
    }

    /**
     * Display the data as palette box.
     *
     * @param array $columns
     * @param string $name
     * @param array $data
     * @param string || array $default_data
     */
    public static function displayPaletteBox($columns, $name, $data, $default_data = null)
    {
        $palette_box = '';
        $checked = '';

        foreach ($data as $row) {
            if (!empty($default_data)) {
                $checked = is_array($default_data) ? (in_array($row['id'], $default_data) ? 'checked' : '') : ($default_data == $row['id'] ? 'checked' : '') ;
            }

            $palette_box .= '<label class=\'palette-box ' . str_replace('skin', 'bg', $row['code']) . "' for='palette-box-{$row['id']}' title='Click to select'>";
            $palette_box .= '<div class=\'palette-box-header\'>';

            foreach ($row as $key => $value) {
                if (in_array($key, $columns)) {
                    $palette_box .= !empty($value) ? "{$value}" : '' ;
                }
            }

            $palette_box .= '</div>';
            $palette_box .= "<input {$checked} id='palette-box-{$row['id']}' name='{$name}' type='radio' value='{$row['id']}'>";
            $palette_box .= '<div class=\'palette-box-overlay\'><i class=\'fa fa-check-circle\'></i></div>';
            $palette_box .= '</label>';
        }

        echo $palette_box;
    }

    /**
     * Display the data as computer box.
     *
     * @param array $columns
     * @param string $name
     * @param array $data
     * @param string || array $default_data
     */
    public static function displayComputerBox($columns, $name, $data, $default_data = null)
    {
        $computer_box = '';
        $checked = '';

        foreach ($data as $row) {
            if (!empty($default_data)) {
                $checked = is_array($default_data) ? (in_array($row['id'], $default_data) ? 'checked' : '') : ($default_data == $row['id'] ? 'checked' : '') ;
            }

            $computer_box .= "<label class='input-box' for='input-box-{$row['id']}' title='Click to select'>";
            $computer_box .= '<div class=\'input-box-header\'>';

            foreach ($row as $key => $value) {
                if (in_array($key, $columns)) {
                    if (!empty($value)) {
                        $computer_box .= "{$value}";
                    } else {
                        $computer_box .= '';
                    }
                }
            }

            $computer_box .= '</div>';
            $computer_box .= "<input {$checked} id='input-box-{$row['id']}' name='{$name}[]' type='checkbox' value='{$row['id']}'>";
            $computer_box .= '<div class=\'input-box-overlay\'><i class=\'fa fa-check-circle\'></i></div>';
            $computer_box .= '</label>';
        }

        echo $computer_box;
    }

    /**
     * Display the data as draggable box.
     *
     * @param array $columns
     * @param string $name
     * @param array $data
     * @param string || array $default_data
     */
    public static function displayDraggableBox($columns, $name, $data, $default_data = null)
    {
        $draggable_box = '';

        foreach ($data as $row) {
            $draggable_box .= "<div type='draggable-box' style='{$row['position']}' title='{$row['position']}'>";
            $draggable_box .= '<h5>';

            foreach ($row as $key => $value) {
                if (in_array($key, $columns)) {
                    $draggable_box .= !empty($value) ? "{$value}" : '' ;
                }
            }

            $draggable_box .= "<input name='{$name}[{$row['id']}][id]' type='hidden' value='{$row['id']}'>";
            $draggable_box .= "<input id='draggable-box-position' name='{$name}[{$row['id']}][position]' type='hidden' value='{$row['position']}'>";
            $draggable_box .= '</h5>';
            $draggable_box .= '</div>';
        }

        echo $draggable_box;
    }
}
