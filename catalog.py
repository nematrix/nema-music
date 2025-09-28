def create_catalog(item1_price, item2_price, item3_price):
    """
    Generates a formatted product catalog for an online store with combos and discounts.
    
    Args:
        item1_price (float): Price of Item 1.
        item2_price (float): Price of Item 2.
        item3_price (float): Price of Item 3.
    """

    # Calculate combo prices with 10% discount
    combo1 = (item1_price + item2_price) * 0.90
    combo2 = (item2_price + item3_price) * 0.90
    combo3 = (item1_price + item3_price) * 0.90

    # Calculate gift pack price with 25% discount
    gift_pack = (item1_price + item2_price + item3_price) * 0.75

    # Output formatting
    print("Output:\n")
    print("Online Store")
    print("-" * 40)
    print(f"{'Product(s)':<30} {'Price (₹)':>10}")
    print("-" * 40)
    print(f"{'Item 1':<30} {item1_price:>10.1f}")
    print(f"{'Item 2':<30} {item2_price:>10.1f}")
    print(f"{'Item 3':<30} {item3_price:>10.1f}")
    print(f"{'Combo 1 (Item 1 + 2)':<30} {combo1:>10.1f}")
    print(f"{'Combo 2 (Item 2 + 3)':<30} {combo2:>10.1f}")
    print(f"{'Combo 3 (Item 1 + 3)':<30} {combo3:>10.1f}")
    print(f"{'Gift Pack (All Items)':<30} {gift_pack:>10.1f}")
    print("-" * 40)
    print("For delivery contact: 98764678899")

# Example call
create_catalog(200.0, 400.0, 600.0)
