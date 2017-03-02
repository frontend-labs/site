<?php
/**
 * Single Post Rating
 * Rating is defined by post author in post edit screen
 *
 * @package SimpleMag
 * @since 	SimpleMag 3.0
**/

// Call total score calculation function
$get_result = apply_filters( 'ti_score_total', '' );

// Get the final score
$total_score = number_format( $get_result, 1, '.', '' );

// If final score is decimal like 5.0 or is equal to 10.0
// remove .0 to display it as integer
if ( strlen ( $total_score ) || $total_score == '10.0' ) {
    $final_result = str_replace( ".0", "", $total_score );
} else {
    $final_result = $total_score;
}

// Multiply by 10 to remove the decimal value
// Displayed in data-cirlce attr.
$final_result_no_decimal = $total_score * 10;

?>
	
<div class="clearfix single-box single-rating">
    
    <?php
    // Output rating note
    $rating_note = get_field( 'rating_note' );
    if ( $rating_note ){
        echo '<p class="description">' . $rating_note . '</p>';
    }
    ?>

    <div class="rating-labels">
        <?php
        $score_output = get_field( 'rating_module' );
        if( $score_output ) :
            foreach( $score_output as $row ) :

            // Get the value from each rating row
            $line_number = str_replace( ".", "", $row['score_number'] );

            // If row value length is only one digit or is equal to number 10
            if ( strlen ( $line_number ) == 1 || $line_number == '10' ) {
                $score_number = $line_number . '0';
            } else {
                $score_number = $line_number;
            }
            ?>

            <div class="rating-labels-item">
                <div class="inner-cell" style="height:<?php echo $score_number + 100 ?>px;">
                    
                    <?php $circle_size = ( $score_number + 100 ) / 40; ?>
                    <span class="rating-circle" style="width:<?php echo esc_attr( $circle_size ); ?>em; height:<?php echo esc_attr( $circle_size ); ?>em">
                        <i><?php echo $row['score_number']; ?></i>
                    </span>
                    <span class="rating-label"><?php echo $row['score_label']; ?></span>
                    
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <div class="indicator-container">
        <div class="rating-total-indicator" data-circle="<?php echo esc_attr( $final_result_no_decimal ); ?>">
            <i class="show-total"><?php echo esc_html( $final_result ); ?></i>
            <div class="sides left-side"><span></span></div>
            <div class="sides right-side"><span></span></div>
        </div>
    </div>

</div><!-- .single-rating -->