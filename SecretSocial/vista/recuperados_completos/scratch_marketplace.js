"const fs = require('fs');

const filepath = 'c:\\xampp\\htdocs\\SecretSocial\\vista\\marketplace.php';
let content = fs.readFileSync(filepath, 'utf8');
content = content.replace(/\\
/g, '\
');

// 1. Add Seller Options HTML in the Detail Modal
const detailModalTarget = `                              <a id="det-btn-mensaje" href="" class="btn btn-primary btn-sm rounded-pill px-4" style="font-weight: 600;"><i class="lab la-rocketchat mr-1"></i> Enviar Mensaje</a>
                          </div>
                      </div>`;

const detailModalReplacement = `                              <a id="det-btn-mensaje" href="" class="btn btn-primary btn-sm rounded-pill px-4" style="font-weight: 600;"><i class="lab la-rocketchat mr-1"></i> Enviar Mensaje</a>
                          </div>
                          <!-- Opciones de Vendedor -->
                          <div id="det-opciones-vendedor" class="mt-3 p-3 border rounded bg-light d-none" style="border-radius: 12px;">
                               <h6 class="font-weight-bold mb-2 text-dark font-size-13"><i class="las la-cog text-primary"></i> Opciones de Vendedor</h6>
                               <div class="d-flex justify-content-between" style="gap: 10px;">
                                   <button type="button" id="btn-marcar-vendido" class="btn btn-warning btn-sm font-weight-bold text-white w-50" style="border-radius: 8px;"><i class="las la-check-circle"></i> Marcar Vendido</button>
                                   <button type="button" id="btn-eliminar-producto" class="btn btn-danger btn-sm font-weight-bold w-50" style="border-radius: 8px;"><i class="las la-trash-alt"></i> Eliminar Artículo</button>
                               </div>
                          </div>
                      </div>`;

if (content.includes(detailModalTarget)) {
    content = content.replace(detailModalTarget, detailModalReplacement);
    console.log("SUCCESS: Seller options co
<truncated 8805 bytes>