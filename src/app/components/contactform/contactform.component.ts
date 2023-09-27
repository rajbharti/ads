import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validator, Validators } from '@angular/forms';
import { MailService } from 'src/app/services/mail.service';
import { emailValidator } from '../../utils/email-validator';

@Component({
  selector: 'app-contactform',
  templateUrl: './contactform.component.html',
  styleUrls: ['./contactform.component.scss'],
})
export class ContactformComponent implements OnInit {
  contactForm!: FormGroup;

  isAPILoading = false;
  isSuccess = false;
  submitMessage = '';
  submitButtonLabel = 'Send';

  constructor(
    private formBuilder: FormBuilder,
    private mailService: MailService
  ) {}

  ngOnInit() {
    this.contactForm = this.formBuilder.group({
      name: [null, Validators.required],
      email: [null, [Validators.required, emailValidator()]],
      message: [null, Validators.required],
      subject: [null, Validators.required],
    });
  }


  submitData(value: any) {
    const payload = {
      name: value.name,
      email: value.email,
      message: value.message,
      subject: value.subject
    };

    this.isAPILoading = true;
    this.submitButtonLabel = 'Sending...';

    this.mailService.sendMail(payload)
      .subscribe(response => {
        this.submitButtonLabel = 'Send';
        this.isAPILoading = false;

        if (response.status) {
          this.contactForm.reset();
          this.isSuccess = true;
          this.submitMessage = "Email sent successfully.";
        } else {
          this.isSuccess = false;
          this.submitMessage = "Email sending failed. Try again!";
        }
        setTimeout(() => {
          this.submitMessage = "";
          this.isSuccess = false;
        }, 5000);
      });
  }
}
