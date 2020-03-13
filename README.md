#Objectsource_ShippingVolumeCap

This extension was created to allow an admin to specify max limit that can be applied to individual shipping rates
that are returned from ShipperHQ. The extension will get all orders from the set cut off time and count the number
of times a shipping method has been used. It will then check this count against a volume cap and hide the shipping 
rate if the volume cap has been exceeded.

This extension has only been built to work with rates returned from ShipperHQ at this point in time.