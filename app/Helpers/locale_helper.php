<?php 

use Config\Services;

// --------------------------------------------------------------------

if ( ! function_usable('select_countries'))
{
    /**
     * Select Countries [name, phonecode]
     *
     * Lets you fetch a list of countries available from the countries database
     *
     * @param   mixed
     * @param   integer 
     * @return  mixed   depends on what the type specifies
     */
    function select_countries($value = '', $row = 'name', $type = 0) 
    { 
        $locale_model = model('App\Models\LocaleModel', false);
        $locale       = $locale_model->fetch_countries(null, 'sortname'); 
        
        if($type == 0) 
        { 
            $options = '<option value="">Select Country</option>';

            foreach($locale AS $country) 
            {
                if(mb_strtolower($value) == mb_strtolower($country[$row])) 
                {
                    $selected = ' selected="selected"';
                } 
                else 
                {
                    $selected = '';
                }

                $text = $country[$row];

                if ($row !== 'name') 
                {
                    $text = $country['sortname'] . ' ' . '+' . $country[$row];
                }

                $options .= '
                <option value="'.$country[$row].'" id="'.$country['id'].'"'.$selected.'>
                    '.$text.
                '</option>';
            }
            return $options;
        } 
        else 
        {
            foreach($locale as $code) 
            {
                if($value == $code['name']) 
                { 
                    return $code['sortname'];
                }
            }
        }   
        return $locale;
    }
}
 

// --------------------------------------------------------------------


if ( ! function_usable('select_states'))
{
    /**
     * Select States
     *
     * Lets you fetch a list of states for the country 
     * specified in the id parameter from the states database
     *
     * @param   mixed 
     * @return  string   html select option of containing a list of states
     */
    function select_states($country_id = '', $value = '') 
    {
        $locale_model = model('App\Models\LocaleModel', false);
        $locale       = $locale_model->fetch_states(['country_id' => $country_id]);  

        $options = '';
            
        foreach($locale AS $state) 
        {
            if(mb_strtolower($value) == mb_strtolower($state['name'])) 
            {
                $selected = ' selected="selected"';
            } 
            else 
            {
                $selected = '';
            }

            $options .= '
            <option value="'.$state['name'].'" id="'.$state['id'].'"'.$selected.'>
                '.$state['name'].
            '</option>';
        }
        return $options;    
    }
}


// --------------------------------------------------------------------


if ( ! function_usable('select_cities'))
{
    /**
     * Select Cites
     *
     * Lets you fetch a list of Cites for the state 
     * specified in the id parameter from the cities database
     *
     * @param   mixed 
     * @return  string   html select option of containing a list of states
     */
    function select_cities($state_id = '', $value = '') 
    { 
        $locale_model = model('App\Models\LocaleModel', false);
        $locale       = $locale_model->fetch_cities(['state_id' => $state_id]);  

        $options = '';
            
        foreach($locale AS $city) 
        {
            if(mb_strtolower($value) == mb_strtolower($city['name'])) 
            {
                $selected = ' selected="selected"';
            } 
            else 
            {
                $selected = '';
            }

            $options .= '
            <option value="'.$city['name'].'" id="'.$city['id'].'"'.$selected.'>'.$city['name'].'</option>';
        }
        return $options;    
    }
}
