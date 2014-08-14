<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
        <th height="35">
            &nbsp;
        </th>
        <th>
            <?php echo __('Categorias')?>
            <?php echo $categoryInNucleo->getCategoria(); ?>
        </th>
    </tr>
  </thead>
  <tbody>
      <tr>
          <td class="borderBottomDarkGray" colspan="2">
              &nbsp;&nbsp;<?php echo __('Selecione a categoria em que aparece a notícia') ?>
          </td>          
      </tr>
      <tr>
          <td class="borderBottomDarkGray" >&nbsp;&nbsp;Categoría:</td>
          <td class="borderBottomDarkGray" >              
            <select name="category" id="category" onchange="javascript:changeCategoryInNuclueByNews(<?php echo $sf_request->getParameter('id_nucleo') ?>, <?php echo $sf_request->getParameter('id_news') ?>);">
              <option value="" ><?php echo __('Nenhum por enquanto') ?></option>
              <?php foreach(sfConfig::get('app_newsConfig_categories') as $id_category => $category): ?>
              <option value="<?php echo $id_category ?>" <?php echo ($id_category == $categoryInNucleo->getCategoria() && $categoryInNucleo->getCategoria() != null)?'selected="selected"':null?>><?php echo $category ?></option>
              <?php endforeach; ?>
            </select>
          </td>
      </tr>
      <tr>
          <td class="borderBottomDarkGray" colspan="2" align="center" style="height: 50px;" valing="top">
              <div id="message">
                  
              </div>
          </td>          
      </tr>
  </tbody>
</table>