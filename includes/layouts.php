<?php function bdpl_contact_name_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'contact_nonce' ); ?>

  <p>
    <label for="contact-name"><?php _e( "Enter the Contact Name" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="contact-name" id="contact-name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'contact-name', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_contact_number_meta_box( $post ) { ?>

  <p>
    <label for="contact-number"><?php _e( "Enter the Contact Number" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="contact-number" id="contact-number" value="<?php echo esc_attr( get_post_meta( $post->ID, 'contact-number', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_contact_role_meta_box( $post ) { ?>

  <p>
    <label for="contact-role"><?php _e( "Enter the Contact's Role" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="contact-role" id="contact-role" value="<?php echo esc_attr( get_post_meta( $post->ID, 'contact-role', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_image_meta_box( $post ) { ?>

  <p>
    <label for="team-image"><?php _e( "Upload a Picture" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="team-image" id="team-image" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-image', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_address_firstline_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'team_nonce' ); ?>

  <p>
    <label for="team-address-firstline"><?php _e( "Enter the first line of the address" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="team-address-firstline" id="team-address-firstline" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-address-firstline', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_address_secondline_meta_box( $post ) { ?>

  <p>
    <label for="team-address-secondline"><?php _e( "Enter the second line of the address" ); ?></label>
    <br />
    <input class="widefat" type="text" name="team-address-secondline" id="team-address-secondline" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-address-secondline', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_town_meta_box( $post ) { ?>

  <p>
    <label for="team-town"><?php _e( "Enter the town" ); ?></label>
    <br />
    <input class="widefat" type="text" name="team-town" id="team-town" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-town', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_postcode_meta_box( $post ) { ?>

  <p>
    <label for="team-postcode"><?php _e( "Enter the postcode" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="team-postcode" id="team-postcode" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-postcode', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_telephone_meta_box( $post ) { ?>

  <p>
    <label for="team-telephone"><?php _e( "Enter the telephone number" ); ?></label>
    <br />
    <input required class="widefat" type="text" name="team-telephone" id="team-telephone" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-telephone', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_website_meta_box( $post ) { ?>

  <p>
    <label for="team-website"><?php _e( "Enter the website" ); ?></label>
    <br />
    <input class="widefat" type="url" name="team-website" id="team-website" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-website', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_email_meta_box( $post ) { ?>

  <p>
    <label for="team-email"><?php _e( "Enter the email address" ); ?></label>
    <br />
    <input class="widefat" type="email" name="team-email" id="team-email" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-email', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_landlord_meta_box( $post ) { ?>

  <p>
    <label for="team-landlord"><?php _e( "Enter the landlord name" ); ?></label>
    <br />
    <input class="widefat" type="text" name="team-landlord" id="team-landlord" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-landlord', true ) ); ?>" size="30" />
  </p>
<?php }


function bdpl_team_captain_a_meta_box( $post ) { ?>

  <p>
    <label for="team-captain-a"><?php _e( "Enter the A team captain" ); ?></label>
    <br />
    <input class="widefat" type="text" name="team-captain-a" id="team-captain-a" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-captain-a', true ) ); ?>" size="30" />
  </p>
<?php }


function bdpl_team_captain_b_meta_box( $post ) { ?>

  <p>
    <label for="team-captain-b"><?php _e( "Enter the B team captain" ); ?></label>
    <br />
    <input class="widefat" type="text" name="team-captain-b" id="team-captain-b" value="<?php echo esc_attr( get_post_meta( $post->ID, 'team-captain-b', true ) ); ?>" size="30" />
  </p>
<?php }

function bdpl_team_management() { ?>
  <h1>Team Management</h1>
  <form method="post" action="teams.php">
  <table class="form-table">
    <thead>
      <tr>
        <th>Team Name</th>
        <th>Fixture Ref</th>
        <th>Division</th>
        <th>Pub</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php global $wpdb; ?>
      <?php $teams = $wpdb->get_results( 'SELECT * FROM wp_teams' ); ?>
      <?php if ($teams) : ?>
        <?php foreach ( $teams as $team ) { ?>
          <tr>
            <td><input type="text" name="bdpl_team_name" value="<?php echo $teams->team_name; ?>"/></td>
            <td><input type="number" name="bdpl_fixture_ref" value="<?php echo $teams->fixture_ref; ?>"/></td>
            <td><input type="number" name="bdpl_division" value="<?php echo $teams->division; ?>"/></td>
            <td>
              <select>
              </select>
            </td>
            <td><button class="btn btn-success">Update</button></td>
            <td><button class="btn btn-danger">Delete</button></td>
          </tr>
        <?php } ?>
      <?php else : ?>
      <tr>
        <td colspan="6"><p>There are no teams.</p></td>
      </tr>
      <tr>
            <td><input type="text" name="bdpl_team_name"/></td>
            <td><input type="number" name="bdpl_fixture_ref"/></td>
            <td><input type="number" name="bdpl_division"/></td>
            <td>
              <select>
              </select>
            </td>
            <td><button class="btn btn-success">Add</button></td>
          </tr>
      <?php endif; ?>
    </tbody>
  </table>  
  </form>
<?php }

function bdpl_fixtures() {

}

function bdpl_ammendments() {

}

