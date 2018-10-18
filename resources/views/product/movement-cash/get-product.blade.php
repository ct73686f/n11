<tr>
    <td>{{ $product->id }}</td>
    <td>{{ $product->barcode->code }}</td>
    <td>{{ $product->description }}</td>
    <td>{{ $quantity }}</td>
    <td>{{ $product->cost->unit_price }}</td>
    <td>{{ $product->cost->unit_cost }}</td>
    <td>{{ number_format($subTotal, 2) }}</td>
</tr>
