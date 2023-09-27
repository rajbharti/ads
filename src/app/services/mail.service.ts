import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, delay, of } from 'rxjs';

@Injectable()
export class MailService {
  constructor(private http: HttpClient) {}

  public sendMail(payload: any): Observable<any> {
    const endpoint = 'https://www.agiledigitalstudio.com/server/send-mail.php';
    return this.http.post(endpoint, payload)
  }
}
