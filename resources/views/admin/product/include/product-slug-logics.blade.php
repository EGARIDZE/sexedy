<script>
    const parent = document.getElementById('product_description-button');
    
    const productOffers = parent.children[0];
    productOffers.href = `{{ route('product.offers.index', ['id' => ':id']) }}`.replace(':id', productId);
    
    const productDetails = parent.children[1];
    productDetails.href = `{{ route('product.details.index', ['id' => ':id']) }}`.replace(':id', productId);
    
    const productFabrics = parent.children[2];
    productFabrics.href = `{{ route('product.fabrics.index', ['id' => ':id']) }}`.replace(':id', productId);
    
    const productCares = parent.children[3];
    productCares.href = `{{ route('product.cares.index', ['id' => ':id']) }}`.replace(':id', productId);
</script>