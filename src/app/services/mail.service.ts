import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable()
export class MailService {
  constructor(private http: HttpClient) {}

  public sendMail(payload: any): Observable<any> {
    const gcpUrl = 'http://34.131.166.105:8080';
    return this.http.post(`${gcpUrl}/send-mail`, payload);
  }
}
