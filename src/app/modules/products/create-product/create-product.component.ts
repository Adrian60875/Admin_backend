
// Importa los módulos necesarios de Angular y otras dependencias
import { Component } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { ProductService } from '../service/product.service';
import { IDropdownSettings } from 'ng-multiselect-dropdown';


// Define el componente con su selector, plantilla y estilos
@Component({
  selector: 'app-create-product',
  templateUrl: './create-product.component.html',
  styleUrls: ['./create-product.component.scss']
})
export class CreateProductComponent {

  config: any = {
    versionCheck: false,
  }
    // Define propiedades para almacenar información del producto y su estado

  title: string = '';
  sku: string = '';
  resumen: string = '';
  price_pen: number = 0;
  price_usd: number = 0;
  description: any = "<p>Hello, world!</p>";
  imagen_previsualiza: any = "https://cdn.icon-icons.com/icons2/2783/PNG/512/photo_upload_icon_177257.png";
  file_imagen: any = null;
  marca_id: string = '';
  marcas: any = [];

  isLoading$: any;

  categorie_first_id: string = '';
  categorie_second_id: string = '';
  categorie_third_id: string = '';
  categories_first: any = [];
  categories_seconds: any = [];
  categories_seconds_backups: any = [];
  categories_thirds: any = [];
  categories_thirds_backups: any = [];

  dropdownList: any = [];
  selectedItems: any = [];
  dropdownSettings: IDropdownSettings = {};
  word: string = '';
 
  isShowMultiselect: Boolean = false;

  // Constructor que inyecta ProductService y ToastrService
  constructor(
    public productService: ProductService,
    public toastr: ToastrService,
  ){}

  // Método que se ejecuta al inicializar el componente
  ngOnInit(): void {
    this.isLoading$ = this.productService.isLoading$;

    // Configura la lista de elementos del dropdown
    this.dropdownList = [
      { item_id: 1, item_text: 'Mumbai' },
      { item_id: 2, item_text: 'Bangaluru' },
      { item_id: 3, item_text: 'Pune' },
      { item_id: 4, item_text: 'Navsari' },
      { item_id: 5, item_text: 'New Delhi' },
      { item_id: 6, item_text: 'Zapatos' }
    ];
    this.selectedItems = [
      { item_id: 3, item_text: 'Pune' },
      { item_id: 4, item_text: 'Navsari' }
    ];
    // Configura los ajustes del dropdown
    this.dropdownSettings = {
      singleSelection: false,
      idField: 'item_id',
      textField: 'item_text',
      selectAllText: 'Select All',
      unSelectAllText: 'UnSelect All',
      allowSearchFilter: true
    };
    // Llama a la función para configurar todos los datos necesarios
    this.configAll();
  }

  // Método para configurar datos iniciales de marcas y categorías
  configAll() {
    this.productService.configAll().subscribe((resp: any) => {
      console.log(resp);
      this.marcas = resp.brands;
      this.categories_first = resp.categories_first; 
      this.categories_seconds = resp.categories_seconds;
      this.categories_thirds = resp.categories_thirds; 
    })
  }

  // Método para agregar elementos al dropdown
  addItems() {
    this.isShowMultiselect = true;
    let time_date = new Date().getTime();
    this.dropdownList.push({ item_id: time_date, item_text: this.word });
    //this.selectedItems.push({ item_id: time_date, item_text: this.word });
    setTimeout(() => {
      this.word = '';
      this.isShowMultiselect = false;
      this.isLoadingView();
    }, 100);
  }

  // Método para procesar el archivo de imagen seleccionado
  processFile($event: any) {
    if ($event.target.files[0].type.indexOf("image") < 0 ) { 
      this.toastr.error("Validacion", "El archivo no es una imagen");
      return;
    }
    this.file_imagen = $event.target.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(this.file_imagen);
    reader.onloadend = () => this.imagen_previsualiza = reader.result;
    this.isLoadingView();
  }

  // Método para mostrar el estado de carga
  isLoadingView() {
    this.productService.isLoadingSubject.next(true);
    setTimeout(() => {
      this.productService.isLoadingSubject.next(false);
    }, 50);
  }

  // Método para cambiar la categoría de departamento
  changeDepartamento() {
    this.categories_seconds_backups = this.categories_seconds.filter((item: any) => 
      item.categorie_second_id == this.categorie_first_id
    );
  }

  // Método para cambiar la subcategoría
  changeCategorie() {
    this.categories_thirds_backups = this.categories_thirds.filter((item: any) => 
      item.categorie_second_id == this.categorie_second_id
    );
  }

  // Método para manejar cambios en el editor de texto
  public onChange(event: any) {
    this.description = event.editor.getData();
  }

  // Método para manejar la selección de un ítem en el dropdown
  onItemSelect(item: any) {
    console.log(item);
  }

  // Método para manejar la selección de todos los ítems en el dropdown
  onSelectAll(items: any) {
    console.log(items);
  }

  // Método para guardar el producto
  save() {
    if (!this.title || !this.sku || !this.price_usd || !this.price_pen || !this.marca_id
      || !this.file_imagen || !this.categorie_first_id || !this.description || !this.resumen || (this.selectedItems == 0)) {
      this.toastr.error("Validacion", "Los campos con el * son obligatorio");
      return;
    }

    let formData = new FormData();
    formData.append("title", this.title);
    formData.append("sku", this.sku);
    formData.append("price_usd", this.price_usd + "");
    formData.append("price_pen", this.price_pen + "");
    formData.append("brand_id", this.marca_id);
    formData.append("portada", this.file_imagen);
    formData.append("categorie_first_id", this.categorie_first_id);
    if (this.categorie_second_id) {
      formData.append("categorie_second_id", this.categorie_second_id);
    }
    if (this.categorie_third_id) {
      formData.append("categorie_third_id", this.categorie_third_id);
    }
    formData.append("description", this.description);
    formData.append("resumen", this.resumen);
    formData.append("multiselect", JSON.stringify(this.selectedItems)); /* tags */

    this.productService.createProducts(formData).subscribe((resp: any) => {
      console.log(resp);

      if (resp.message == 403) {
        this.toastr.error("Validación", resp.message_text);
      } else {
        // Resetea los campos del formulario después de guardar exitosamente
        this.title = '';
        this.file_imagen = null;
        this.sku = '';
        this.price_usd = 0;
        this.price_pen = 0;
        this.marca_id = '';
        this.categorie_first_id = '';
        this.categorie_second_id = '';
        this.categorie_third_id = '';
        this.description = '';
        this.resumen = '';
        this.selectedItems = [];
        this.imagen_previsualiza = "https://cdn.icon-icons.com/icons2/2783/PNG/512/photo_upload_icon_177257.png";
        this.toastr.success("Exito", "El producto se registró correctamente");
      }
    })
  }
}
