// Importa módulos necesarios de Angular y otras dependencias
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, BehaviorSubject, finalize } from 'rxjs';
import { URL_SERVICIOS } from 'src/app/config/config';
import { AuthService } from '../../auth';

// Marca la clase ProductService como inyectable, disponible en la raíz de la aplicación
@Injectable({
  providedIn: 'root'
})
export class ProductService {

  // Define observables y sujetos para el estado de carga
  isLoading$: Observable<boolean>;
  isLoadingSubject: BehaviorSubject<boolean>;

  // Constructor de la clase, inyecta HttpClient y AuthService, y configura el sujeto de carga
  constructor(
    private http: HttpClient,
    public authservice: AuthService,
  ) {
    this.isLoadingSubject = new BehaviorSubject<boolean>(false);
    this.isLoading$ = this.isLoadingSubject.asObservable();
  }

  // Método para listar productos con paginación y datos adicionales
  listProducts(page: number = 1, data: any) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products/index?page=" + page;
    return this.http.post(URL, data, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para obtener la configuración de todos los productos
  configAll() {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products/config";
    return this.http.get(URL, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para crear nuevos productos
  createProducts(data: any) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products";
    return this.http.post(URL, data, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para mostrar detalles de un producto específico
  showProduct(product_id: string) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products/" + product_id;
    return this.http.get(URL, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para actualizar productos existentes
  updateProducts(product_id: string, data: any) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products/" + product_id;
    return this.http.post(URL, data, { headers: headers }).pipe( // Se usa POST porque se envía una imagen para la edición
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para eliminar un producto específico
  deleteProduct(product_id: string) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/sliders/" + product_id;
    return this.http.delete(URL, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para agregar una imagen a un producto
  imagenAdd(data: any) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products/imagens";
    return this.http.post(URL, data, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }

  // Método para eliminar una imagen de un producto
  deleteImageProduct(imagen_id: string) {
    this.isLoadingSubject.next(true);
    let headers = new HttpHeaders({'Authorization': 'Bearer ' + this.authservice.token});
    let URL = URL_SERVICIOS + "/admin/products/imagens/" + imagen_id;
    return this.http.delete(URL, { headers: headers }).pipe(
      finalize(() => this.isLoadingSubject.next(false))
    );
  }
}
