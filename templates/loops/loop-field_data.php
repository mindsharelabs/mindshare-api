<?php
$fields = get_fields(get_the_id());
$dimensions = get_the_terms( get_the_id(), 'dimension_category' );
$codes  = get_the_terms( get_the_id(), 'quote_codes' );
$descriptions  = get_the_terms( get_the_id(), 'doc_description' );

echo '<div class="col-12">';
  echo '<div class="card d-flex flex-row justify-space-between p-2 mb-4">';

    echo '<div class="d-flex flex-column justify-space-between w-75 pr-4">';
      echo '<div class="content">' . $fields['quote_content'] . '</div>';

      if($descriptions) :
        echo '<hr><strong><div class="description">';
          echo '<span class="tax-label"><strong>Descriptions: </strong><br/></span>';
          foreach ($descriptions as $key => $desc) :
            //echo '<a href="' . get_term_link($code, 'dimension_category') . '">' . $code->name . '</a>';
            echo $desc->name;
          endforeach;
        echo '</strong></div>';
      endif;

    echo '</div>';


    if($dimensions || $codes || $fields['quote_id'] || $fields['document_number']) :
      echo '<div class="d-flex flex-column justify-space-between w-25 mt-0">';
        if($dimensions) :
          echo '<div class="dimension-category small mt-2">';
            echo '<span class="tax-label"><strong>Dimension Categories: </strong><br/></span>';
            foreach ($dimensions as $key => $dimension) :
              //echo '<a href="' . get_term_link($dimension, 'dimension_category') . '">' . $dimension->name . '</a>';
              echo $dimension->name;
            endforeach;
          echo '</div>';
        endif;


        if($codes) :
          echo '<div class="quote-codes small mt-2">';
            echo '<span class="tax-label"><strong>Codes: </strong><br/></span>';
            foreach ($codes as $key => $code) :
              //echo '<a href="' . get_term_link($code, 'dimension_category') . '">' . $code->name . '</a>';
              echo $code->name;
            endforeach;
          echo '</div>';
        endif;


        if($fields['quote_id']) :
          echo '<div class="quote-id small mt-2">';
            echo '<span class="tax-label"><strong>Quote ID: </strong><br/></span>';
            echo '<span class="quote-id">' . $fields['quote_id'] . '</span>';
          echo '</div>';
        endif;


        if( $fields['document_number']) :
          echo '<div class="document-number small mt-2">';
            echo '<span class="tax-label"><strong>Document Number: </strong><br/></span>';
            echo '<span class="quote-id">' . $fields['document_number'] . '</span>';
          echo '</div>';
        endif;


      echo '</div>';
    endif;


  echo '</div>';
echo '</div>';
