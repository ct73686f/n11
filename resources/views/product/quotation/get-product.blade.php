<tr>
    <td>{{ $product->id }}</td>
    <td>{{ $product->barcode->code }}</td>
    <td>{{ $product->description }}</td>
    <td>{{ $quantity }}</td>
    <td>{{ $product->cost->unit_price }}</td>
    <td>{{ $product->cost->wholesale_price }}</td>
    <td>{{ number_format($subTotal, 2) }}</td>
    <td><a href="#" class="btn btn-secondary btn-sm product-remove"><i class="fa fa-remove"></i></a></td>
</tr>
