import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AttributesRoutingModule } from './attributes-routing.module';
import { AttributesComponent } from './attributes.component';
import { CreateAttributeComponent } from './create-attribute/create-attribute.component';
import { DeleteAttributeComponent } from './delete-attribute/delete-attribute.component';
import { ListAttributeComponent } from './list-attribute/list-attribute.component';
import { SubAttributeCreateComponent } from './sub-attribute-create/sub-attribute-create.component';
import { SubAttributeDeleteComponent } from './sub-attribute-delete/sub-attribute-delete.component';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgbModule, NgbModalModule, NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { InlineSVGModule } from 'ng-inline-svg-2';
import { EditAttributeComponent } from './edit-attribute/edit-attribute.component';


@NgModule({
  declarations: [
    AttributesComponent,
    CreateAttributeComponent,
    DeleteAttributeComponent,
    ListAttributeComponent,
    SubAttributeCreateComponent,
    SubAttributeDeleteComponent,
    EditAttributeComponent
  ],
  imports: [
    CommonModule,
    AttributesRoutingModule,

    HttpClientModule,
    FormsModule,
    NgbModule,
    ReactiveFormsModule,
    InlineSVGModule, // DE METRONICK
    NgbModalModule,
    NgbPaginationModule,


  ]
})
export class AttributesModule { }
