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

  isSubmit = true;
  submitMessage = '';
  logoUrl =
    'https://www.agiledigitalstudio.com/assets/images/logo-emailtemplate.jpg';

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
    this.createPayload(value);
    this.submitMessage = 'Submitted Sucessfully';
    setTimeout(() => {
      this.isSubmit = false;
    }, 4000);
  }

  createPayload(value: any) {
    const payload = {
      from: 'TESTING ',
      to: value.email,
      subject: value.subject,
      name: value.name,
      message: value.message,
      email: value.email,
      logoSrc: this.logoUrl,
    };
    this.mailService.sendMail(payload).subscribe();
  }
}
