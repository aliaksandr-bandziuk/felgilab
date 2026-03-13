<? /* Template Name: index page template */ ?>
<? get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

    <section class="final-contact">
      <div class="final-contact__container">
        <div class="final-contact__wrapper">
          <div class="final-contact__map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2449.117693444661!2d20.921476976993176!3d52.13218056486965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471933fb7fe71edb%3A0xa3139f1d9ffeb62a!2sRenowacja%20Felg%20FelgiLab!5e0!3m2!1sen!2spl!4v1773328917158!5m2!1sen!2spl" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="final-contact__inner">
            <h2 class="h2-white mb20">Contact Us Today</h2>
            <div class="about-company__divider mb30">
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="8" aria-hidden="true">
                <path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
              </svg>
            </div>
            <p class="final-contact__description mb20">Have a project in mind? Fill out the form below, and our team will get back to you within 24 hours.</p>
            <form action="#" autocomplete="off" class="small-form">
              <div class="input-container">
                <input type="text" name="name" class="input-contact" />
                <label for="">Name</label>
                <span>Name</span>
              </div>
              <div class="input-container">
                <input type="tel" name="phone" class="input-contact" />
                <label for="">Phone</label>
                <span>Phone</span>
              </div>
              <div class="input-container textarea">
                <textarea name="message" class="input-contact"></textarea>
                <label for="">Message</label>
                <span>Message</span>
              </div>
              <div class="file-upload">
                <input
                  type="file"
                  name="wheel_photos[]"
                  id="wheel_photos"
                  class="input-file"
                  accept="image/*"
                  multiple />
                <label for="wheel_photos" class="file-label">
                  Dodaj zdjęcia uszkodzonych felg
                </label>
                <div class="file-note">Możesz dodać kilka zdjęć (JPG, PNG, WebP).</div>
                <div class="file-list" id="fileList"></div>
              </div>
              <button type="submit" class="button-primary btn" aria-label="Send form">
                Get a Quote
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

  </div>
</main>
<? get_footer() ?>