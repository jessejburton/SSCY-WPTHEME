

<div class="registration-form">
  <h1>Class Registration</h1>
  <h2><span class="class__name"></span> - <span class="class__date"></span></h2>

    <div class="modal__autoreply"></div>

    <div class="input__group">
        <input class="modal__input" type="text" id="name_first" placeholder="First Name" value="<?php echo $name_first; ?>">
    </div>

    <div class="input__group">
        <input class="modal__input" type="text" id="name_last" placeholder="Last Name" value="<?php echo $name_last; ?>">
    </div>

    <div class="input__group">
        <input class="modal__input" type="text" id="email" placeholder="Email" value="<?php echo $email; ?>">
    </div>

  <?php if(!$waiver) { ?>
    <!-- Sign the waiver if they haven't already. -->
    <h4>Acknowledgments</h4>
    <div class="input__group">
      <textarea class="input__textarea waiver" readonly>
  Yoga Instruction and Liability Waiver and Release

  I understand that yoga is an ancient Indian system designed to make the body strong and flexible. I realise that it is important never to do any practice to the point of pain or discomfort. I am aware that there is some risk involved in all physical exercise and that I am responsible for recognising my own physical limits.

  I understand that yoga is not a substitute for medical attention, examination, diagnosis or treatment, and that practising yoga is not recommended and is not safe under certain medical conditions. If I have any concerns about whether yoga is suitable for me or if I have a particular injury or medical condition, I will consult my physician before participating in a yoga class.

  I hereby agree to irrevocably waive, release and discharge any and all claims and liabilities against the Salt Spring Centre of Yoga, its individual instructors or staff, and/or Dharma Sara Satsang Society for any personal injury, death or damage to the person or property.
      </textarea>

      <p>
          <label style="font-weight: normal;"><input type="checkbox" id="waiver_checkbox"> By checking this box and entering your name you agree to all of the terms and conditions listed above. Please read the terms carefully.</label>
      </p>
    </div>
  <?php } else { ?>
    <input type="checkbox" class="hidden" id="waiver_checkbox" checked>
  <?php } ?>

  <div class="modal__buttons">
      <a class="modal__footer-link modal__cancel" href="#">cancel</a>
      <a class="modal__footer-button button modal__action" href="#">Register</a>

      <!-- Hidden Input -->
      <input type="hidden" id="class_date" value="">
      <input type="hidden" id="class_id" value="">
  </div>
</div>